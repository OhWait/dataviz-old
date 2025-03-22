<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted, reactive } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.vectorgrid';

interface IProperties {
  id: number;
  insee_com?: string;
  nom?: string;
}

const selectedFilters = reactive<{ codgeo: string }[]>([
  { codgeo: '64102' },
  { codgeo: '64024' },
  { codgeo: '64122' },
]);

// TODO : Remove this when the issue is fixed
// @ts-ignore
L.DomEvent.fakeStop = () => true;

// Methods
const municipalityStyle = (properties: IProperties): L.PathOptions => {
  const selectedCodes = selectedFilters.map(filter => filter.codgeo);
  return {
    weight: 0.5,
    color: '#000000',
    fillColor: selectedCodes.includes(properties.insee_com ?? '')
      ? '#ffcc00'
      : '#f0f0f0',
    fillOpacity: selectedCodes.includes(properties.insee_com ?? '') ? 0.9 : 0.5,
    fill: true,
    dashArray: selectedCodes.includes(properties.insee_com ?? '') ? '' : '3,3',
  };
};

// Définition du style pour les Piics
const piicStyle = (): L.PathOptions => ({
  weight: 1,
  color: 'red',
  fillColor: 'blue',
  fillOpacity: 0.5,
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

  // Couches vectorielles
  const municipalityLayer = L.vectorGrid.protobuf(
    'http://localhost:7800/territoire.municipality/{z}/{x}/{y}.pbf',
    {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        'territoire.municipality': ((
          properties: IProperties
        ): L.PathOptions => {
          return municipalityStyle(properties);
        }) as unknown as L.PathOptions,
      },
      getFeatureId: (f: any) => f.properties.id,
    }
  );

  const piicLayer = L.vectorGrid.protobuf(
    'http://localhost:7800/territoire.piic/{z}/{x}/{y}.pbf',
    {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        'territoire.piic': piicStyle(),
      },
      getFeatureId: (f: any) => f.properties.id,
    }
  );

  // Gestion des événements pour afficher un popup au survol
  municipalityLayer.on('mousemove', (e: any) => {
    const properties: IProperties = e.sourceTarget.properties;
    if (properties?.insee_com && properties?.nom) {
      popup
        .setLatLng(e.latlng)
        .setContent(`(${properties.insee_com}) ${properties.nom}`)
        .openOn(map);
    } else {
      console.error('No insee_com or nom property found', properties);
    }
  });

  municipalityLayer.on('mouseout', () => popup.remove());

  // Gestion du clic pour sélectionner/désélectionner une commune
  municipalityLayer.on('click', (e: any) => {
    const properties: IProperties = e.sourceTarget.properties;
    if (properties?.insee_com) {
      const index = selectedFilters.findIndex(
        filter => filter.codgeo === properties.insee_com
      );

      if (index === -1) {
        selectedFilters.push({ codgeo: properties.insee_com });
      } else {
        selectedFilters.splice(index, 1);
      }

      municipalityLayer.setFeatureStyle(
        properties.id,
        municipalityStyle(properties)
      );
    } else {
      console.error('No insee_com property found', properties);
    }
  });

  // Gestion des couches Leaflet
  const overlayMaps = {
    Municipalities: municipalityLayer,
    Piics: piicLayer,
  };

  L.control.layers({ OpenStreetMap: baseLayer }, overlayMaps).addTo(map);

  // Ajout des couches par défaut
  municipalityLayer.addTo(map);
  piicLayer.addTo(map);
});
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
