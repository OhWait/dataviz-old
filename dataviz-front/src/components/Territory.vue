<template>
  <div id="map"></div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import 'leaflet.vectorgrid';

onMounted(() => {
  const map = L.map('map').setView([46.6031, 1.8883], 6);

  // Fond de carte OSM
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
  }).addTo(map);

  // Création d'un popup unique
  const popup = L.popup({
    closeButton: false,
    autoClose: false,
    className: 'custom-popup',
    offset: [0, -10],
  });

  // Couche vectorielle
  const vectorTileLayer = L.vectorGrid
    .protobuf('http://localhost:7800/territoire.municipality/{z}/{x}/{y}.pbf', {
      rendererFactory: L.canvas.tile,
      interactive: true,
      vectorTileLayerStyles: {
        municipality: {
          weight: 1,
          color: '#000000',
          fillColor: '#ffffff',
          fillOpacity: 0.5,
          fill: true,
        },
      },
    })
    .addTo(map);

  // Affichage dynamique du popup au survol
  vectorTileLayer.on('mousemove', e => {
    interface IProperties {
      insee_com: String;
      nom_com: String;
    }
    const properties: IProperties = e.sourceTarget.properties;

    if (properties?.insee_com && properties?.nom_com) {
      const popupContent = `(${properties.insee_com}) ${properties.nom_com}`;
      popup.setLatLng(e.latlng).setContent(popupContent).openOn(map);
    }
  });

  vectorTileLayer.on('mouseout', () => popup.remove());
});
</script>

<style>
#map {
  width: 100%;
  height: 100vh;
}

/* Optionnel : Personnalisation du popup */
.custom-popup {
  font-size: 14px;
  font-weight: bold;
}
</style>
