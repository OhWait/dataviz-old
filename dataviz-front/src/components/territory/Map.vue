<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted, reactive, ref } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.vectorgrid';
import { url } from 'inspector';

interface IProperties {
  id: number;
  insee_com?: string;
  nom_com?: string;
}

const selectedFilters = reactive([
  { codgeo: '64102' },
  { codgeo: '64024' },
  { codgeo: '64122' },
]);

// TODO : Remove this when the issue is fixed
// @ts-ignore
L.DomEvent.fakeStop = function () {
  return true;
};

// Methods
const municipalityStyle = (properties: IProperties): L.PathOptions => {
  const selectedCodes = selectedFilters.map(filter => filter.codgeo);

  if (properties.insee_com && selectedCodes.includes(properties.insee_com)) {
    return {
      weight: 0.5,
      color: '#000000',
      fillColor: '#ffcc00',
      fillOpacity: 0.9,
      fill: true,
    };
  }

  return {
    weight: 0.5,
    color: '#000000',
    fillColor: '#f0f0f0',
    fillOpacity: 0.5,
    fill: true,
    dashArray: '3,3',
  };
};

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

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
  }).addTo(map);

  const popup = L.popup({
    closeButton: false,
    autoClose: false,
    className: 'custom-popup',
    offset: [0, -10],
  });

  // ?filter=nom_com%20ILIKE%20%27%25Dax%25%27 to filter on cities
  const vectorTileLayer = L.vectorGrid
    .protobuf(`http://localhost:7800/territoire.municipality/{z}/{x}/{y}.pbf`, {
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
    })
    .addTo(map);

  vectorTileLayer.on('mousemove', e => {
    const properties: IProperties = e.sourceTarget.properties;

    if (properties?.insee_com && properties?.nom_com) {
      const popupContent = `(${properties.insee_com}) ${properties.nom_com}`;
      popup.setLatLng(e.latlng).setContent(popupContent).openOn(map);
    }
  });

  vectorTileLayer.on('mouseout', () => popup.remove());

  vectorTileLayer.on('click', e => {
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

      vectorTileLayer.setFeatureStyle(
        properties.id,
        municipalityStyle(properties)
      );
    }
  });
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
