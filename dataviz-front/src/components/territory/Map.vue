<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted, nextTick, watch } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.vectorgrid';
import {
  IDepartment,
  IMunicipality,
  IPiic,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';

// TODO : Remove this when the issue is fixed
// @ts-ignore
L.DomEvent.fakeStop = () => true;

// Déclaration des références réactives
let map: L.Map;
let municipalityLayer: L.VectorGrid.Protobuf;
let piicLayer: L.VectorGrid.Protobuf;
let departmentLayer: L.VectorGrid.Protobuf;

// Props et Événements
const props = defineProps<{
  selectedMunicipalities: IMunicipality[];
  currentGranularity: Granularity;
}>();
const emit = defineEmits<{
  (e: 'selectMunicipality', municipality: IMunicipality): void;
  (e: 'selectPiic', piic: IPiic): void;
  (e: 'selectDepartment', department: IDepartment): void;
  (e: 'updateGranularity', granularity: Granularity): void;
}>();

// Methods
const activeMunicipalityStyle = (): L.PathOptions => ({
  weight: 0.5,
  color: '#000000',
  fillColor: '#ffcc00',
  fillOpacity: 0.9,
  fill: true,
  dashArray: '3.3',
});

const defaultMunicipalityStyle = (): L.PathOptions => ({
  weight: 0.5,
  color: '#000000',
  fillColor: '#f0f0f0',
  fillOpacity: 0.5,
  fill: true,
  dashArray: '',
});

const piicStyle = (): L.PathOptions => ({
  weight: 1,
  color: 'red',
  fill: false,
});

const departmentStyle = (): L.PathOptions => ({
  weight: 1,
  color: 'blue',
  fill: false,
});

const activeMunicipality = (municipality: IMunicipality) =>
  municipalityLayer.setFeatureStyle(
    // @ts-ignore
    municipality.codgeo,
    activeMunicipalityStyle()
  );

const removeMunicipality = (municipality: IMunicipality) =>
  municipalityLayer.setFeatureStyle(
    // @ts-ignore
    municipality.codgeo,
    defaultMunicipalityStyle()
  );

const updateLayers = (granularity: Granularity) => {
  if (granularity === Granularity.Piic)
    map.addLayer(piicLayer).removeLayer(departmentLayer);
  if (granularity === Granularity.Department)
    map.addLayer(departmentLayer).removeLayer(piicLayer);
};

// Fonction d'initialisation de la carte
const initMap = () => {
  map = L.map('map', {
    center: [46.6031, 1.8883],
    zoom: 6,
    minZoom: 6,
    maxZoom: 12,
    maxBounds: L.latLngBounds(
      L.latLng(41.303, -5.141),
      L.latLng(51.124, 9.662)
    ),
    maxBoundsViscosity: 1.0,
  });

  const openStreetMap = L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
      maxZoom: 19,
    } as L.TileLayerOptions
  );

  const popup = L.popup({
    closeButton: false,
    autoClose: false,
    className: 'custom-popup',
    offset: [0, -10],
  });

  // Création des couches vectorielles
  municipalityLayer = L.vectorGrid
    .protobuf('http://localhost:7800/territoire.municipality/{z}/{x}/{y}.pbf', {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        'territoire.municipality': defaultMunicipalityStyle(),
      },
      getFeatureId: (f: any) => f.properties.codgeo,
    })
    .on('mousemove', (e: any) => {
      const properties: IMunicipality = e.sourceTarget.properties;
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.codgeo}) ${properties.label}`)
        .openOn(map);
    })
    .on('mouseout', () => popup.remove())
    .on('click', (e: any) =>
      emit('selectMunicipality', e.sourceTarget.properties)
    );

  piicLayer = L.vectorGrid
    .protobuf('http://localhost:7800/territoire.piic/{z}/{x}/{y}.pbf', {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        'territoire.piic': piicStyle(),
      },
      getFeatureId: (f: any) => f.properties.epci,
    })
    .on('mousemove', (e: any) => {
      const properties: IPiic = e.sourceTarget.properties;
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.codeepci}) ${properties.label}`)
        .openOn(map);
    })
    .on('mouseout', () => popup.remove())
    .on('click', (e: any) => emit('selectPiic', e.sourceTarget.properties));

  departmentLayer = L.vectorGrid
    .protobuf('http://localhost:7800/territoire.department/{z}/{x}/{y}.pbf', {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        'territoire.department': departmentStyle(),
      },
      getFeatureId: (f: any) => f.properties.epci,
    })
    .on('mousemove', (e: any) => {
      const properties: IDepartment = e.sourceTarget.properties;
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.codedep}) ${properties.label}`)
        .openOn(map);
    })
    .on('mouseout', () => popup.remove())
    .on('click', (e: any) =>
      emit('selectDepartment', e.sourceTarget.properties)
    );

  L.control
    .layers(
      { openStreetMap },
      { Piics: piicLayer, Departments: departmentLayer }
    )
    .addTo(map);

  map
    .addLayer(openStreetMap)
    .addLayer(municipalityLayer)
    .on('overlayadd', (e: any) => {
      if (e.name === 'Piics') emit('updateGranularity', Granularity.Piic);
      if (e.name === 'Departments')
        emit('updateGranularity', Granularity.Department);
    });
};

onMounted(() => nextTick(() => initMap()));

defineExpose({ removeMunicipality, activeMunicipality });

watch(() => props.currentGranularity, updateLayers);
</script>

<style>
#map {
  width: 100%;
  height: 100vh;
}

.custom-popup {
  font-size: 14px;
  font-weight: bold;
}
</style>
