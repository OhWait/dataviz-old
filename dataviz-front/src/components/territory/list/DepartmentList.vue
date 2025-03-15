<template>
  <v-list>
    <v-list-item
      v-for="item in data"
      :key="item.dep"
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
import { IDepartmentCollection } from '@/@types/dataviz/administrativeDivision';

// Props
defineProps<{
  data: IDepartmentCollection[];
}>();

// Emits
const emit = defineEmits<{
  (e: 'select', piic: IDepartmentCollection): void;
}>();

// Methods
const selectPiic = (piic: IDepartmentCollection) => emit('select', piic);
</script>
