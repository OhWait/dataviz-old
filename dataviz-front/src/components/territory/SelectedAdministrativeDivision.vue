<template>
  <v-card class="mt-4">
    <v-card-title>Territoires sélectionnés</v-card-title>

    <v-divider></v-divider>

    <v-list dense>
      <v-list-item
        v-for="territory in selectedTerritories"
        :key="territory.codgeo"
      >
        <v-list-item-title>{{ territory.label }}</v-list-item-title>

        <template v-slot:append>
          <v-list-item-action start>
            <v-icon
              icon="mdi-close"
              @click="$emit('remove-territory', territory)"
            />
          </v-list-item-action>
        </template>
      </v-list-item>

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
