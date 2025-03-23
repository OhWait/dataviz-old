<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted, ref, watch, nextTick } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.vectorgrid';
import { IMunicipality, IPiic } from '@/@types/dataviz/administrativeDivision';

interface IMunicipalityProperties {
  insee_com: string;
  nom: string;
}

interface IPiicProperties {
  annee: number;
  epci: string;
  libepci: string;
}

// TODO : Remove this when the issue is fixed
// @ts-ignore
L.DomEvent.fakeStop = () => true;

// Déclaration des références réactives
let map: L.Map;
let municipalityLayer: L.VectorGrid.Protobuf;
let piicLayer: L.VectorGrid.Protobuf;

// Props et Événements
const props = defineProps<{ selectedMunicipalities: IMunicipality[] }>();
const emit = defineEmits<{
  (e: 'selectMunicipality', municipality: IMunicipality): void;
  (e: 'selectPiic', piic: IPiic): void;
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

const activeMunicipality = (municipality: IMunicipality) => {
  municipalityLayer.setFeatureStyle(
    // @ts-ignore
    municipality.codgeo,
    activeMunicipalityStyle()
  );
};
const removeMunicipality = (municipality: IMunicipality) => {
  municipalityLayer.setFeatureStyle(
    // @ts-ignore
    municipality.codgeo,
    defaultMunicipalityStyle()
  );
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
      getFeatureId: (f: any) => f.properties.insee_com,
    })
    .on('mousemove', (e: any) => {
      const properties: IMunicipalityProperties = e.sourceTarget.properties;
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.insee_com}) ${properties.nom}`)
        .openOn(map);
    })
    .on('mouseout', () => popup.remove())
    .on('click', (e: any) => {
      const properties: IMunicipalityProperties = e.sourceTarget.properties;
      emit('selectMunicipality', {
        codgeo: properties.insee_com,
        label: properties.nom,
      });
    });

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
      const properties: IPiicProperties = e.sourceTarget.properties;
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.epci}) ${properties.libepci}`)
        .openOn(map);
    })
    .on('mouseout', () => popup.remove())
    .on('click', (e: any) => {
      const piic: IPiicProperties = e.sourceTarget.properties;
      emit('selectPiic', { epci: piic.epci, label: piic.libepci, nature: '' });
    });

  L.control.layers({ openStreetMap }, { Piics: piicLayer }).addTo(map);

  map.addLayer(openStreetMap).addLayer(municipalityLayer).addLayer(piicLayer);
};

onMounted(() => nextTick(() => initMap()));

defineExpose({ removeMunicipality, activeMunicipality });
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
