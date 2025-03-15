<template>
  <v-list>
    <v-list-item
      v-for="item in data"
      :key="item.epci"
      @click="selectPiic(item)"
    >
      <v-list-item-title>{{ item.label }}</v-list-item-title>

      <v-list-item-subtitle>
        {{ item.nbMunicipalities }} municipalities
      </v-list-item-subtitle>
    </v-list-item>
  </v-list>
</template>

<script setup lang="ts">
import { IPiicCollection } from '@/@types/dataviz/administrativeDivision';

// Props
defineProps<{
  data: IPiicCollection[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'select', piic: IPiicCollection): void;
}>();

// Methods
const selectPiic = (piic: IPiicCollection) => emit('select', piic);
</script>
