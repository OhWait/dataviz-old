<template>
  <v-list>
    <v-list-item
      v-for="item in data"
      :key="item.codgeo"
      @click="$emit('select', item)"
    >
      <v-list-item-title>{{ item.label }}</v-list-item-title>

      <v-list-item-subtitle v-if="item.piic">
        {{ item.piic.label }}
      </v-list-item-subtitle>

      <v-list-item-subtitle>
        ({{ item.department.codedep }}) {{ item.department.label }}
      </v-list-item-subtitle>
    </v-list-item>
  </v-list>
</template>

<script setup lang="ts">
import { IMunicipalityCollection } from '@/@types/dataviz/administrativeDivision';

// Props
defineProps<{
  data: IMunicipalityCollection[];
}>();

// Emits
defineEmits<{
  (e: 'select', municipality: IMunicipalityCollection): void;
}>();
</script>
