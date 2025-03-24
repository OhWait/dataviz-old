<template>
  <v-card class="mt-4">
    <v-card-title>Territoires sélectionnés</v-card-title>

    <v-divider></v-divider>

    <v-list dense>
      <v-chip
        v-for="territory in selectedTerritories"
        :key="territory.codgeo"
        class="ma-2"
        closable
        @click:close="$emit('remove-territory', territory)"
      >
        {{ territory.label }}
      </v-chip>

      <v-list-item v-if="selectedTerritories.length === 0">
        <v-list-item-title>Aucun territoire sélectionné</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-card>
</template>

<script setup lang="ts">
import { IMunicipality } from '@/@types/dataviz/administrativeDivision';
import { defineProps, defineEmits } from 'vue';

defineProps<{
  selectedTerritories: IMunicipality[];
}>();

defineEmits(['remove-territory']);
</script>
