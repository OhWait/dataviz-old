<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted, watch } from 'vue';
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

const municipalityLayer = L.vectorGrid.protobuf(
  'http://localhost:7800/territoire.municipality/{z}/{x}/{y}.pbf',
  {
    rendererFactory: L.canvas.tile,
    interactive: true,
    vectorTileLayerStyles: {
      'territoire.municipality': ((properties: IMunicipalityProperties) =>
        municipalityStyle({
          codgeo: properties.insee_com,
          label: properties.nom,
        })) as L.PathOptions,
    },
    getFeatureId: (f: any) => f.properties.codgeo,
  }
);

const piicLayer = L.vectorGrid.protobuf(
  'http://localhost:7800/territoire.piic/{z}/{x}/{y}.pbf',
  {
    rendererFactory: L.canvas.tile,
    interactive: true,
    vectorTileLayerStyles: {
      'territoire.piic': (() => piicStyle()) as L.PathOptions,
    },
    getFeatureId: (f: any) => f.properties.epci,
  }
);

// TODO : Remove this when the issue is fixed
// @ts-ignore
L.DomEvent.fakeStop = () => true;

// Props
const props = defineProps<{
  selectedMunicipalities: IMunicipality[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'selectMunicipality', municipality: IMunicipality): void;
  (e: 'selectPiic', piic: IPiic): void;
}>();

// Methods
const municipalityStyle = (properties: IMunicipality): L.PathOptions => {
  const selectedCodes = props.selectedMunicipalities.map(
    filter => filter.codgeo
  );
  return {
    weight: 0.5,
    color: '#000000',
    fillColor: selectedCodes.includes(properties.codgeo ?? '')
      ? '#ffcc00'
      : '#f0f0f0',
    fillOpacity: selectedCodes.includes(properties.codgeo ?? '') ? 0.9 : 0.5,
    fill: true,
    dashArray: selectedCodes.includes(properties.codgeo ?? '') ? '' : '3,3',
  };
};

const piicStyle = (): L.PathOptions => ({
  weight: 1,
  color: 'red',
  fill: false,
});

onMounted(() => {
  const maxBounds = L.latLngBounds(
    L.latLng(41.303, -5.141),
    L.latLng(51.124, 9.662)
  );

  const map = L.map('map', {
    center: [46.6031, 1.8883],
    zoom: 6,
    minZoom: 6,
    maxZoom: 12,
    maxBounds,
    maxBoundsViscosity: 1.0,
  });

  const baseLayer = L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
      maxZoom: 19,
    }
  ).addTo(map);

  const popup = L.popup({
    closeButton: false,
    autoClose: false,
    className: 'custom-popup',
    offset: [0, -10],
  });

  // Gestion des événements pour afficher un popup au survol
  municipalityLayer.on('mousemove', (e: any) => {
    const properties: IMunicipalityProperties = e.sourceTarget.properties;
    if (properties?.insee_com && properties?.nom) {
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.insee_com}) ${properties.nom}`)
        .openOn(map);
    } else {
      console.error('No insee_com or nom property found', properties);
    }
  });

  piicLayer.on('mousemove', (e: any) => {
    const properties: IPiicProperties = e.sourceTarget.properties;
    popup
      .setLatLng(e.latlng)
      .setContent(`(${properties.epci}) ${properties.libepci}`)
      .openOn(map);
  });

  municipalityLayer.on('mouseout', () => popup.remove());
  piicLayer.on('mouseout', () => popup.remove());

  municipalityLayer.on('click', (e: any) => {
    const properties: IMunicipalityProperties = e.sourceTarget.properties;

    emit('selectMunicipality', {
      codgeo: properties.insee_com,
      label: properties.nom,
    });
  });

  piicLayer.on('click', (e: any) => {
    const piic: IPiicProperties = e.sourceTarget.properties;

    emit('selectPiic', {
      epci: piic.epci,
      label: piic.libepci,
      nature: '',
    });
  });

  L.control
    .layers({ OpenStreetMap: baseLayer }, { Piics: piicLayer })
    .addTo(map);

  municipalityLayer.addTo(map);
  piicLayer.addTo(map);
});
</script>