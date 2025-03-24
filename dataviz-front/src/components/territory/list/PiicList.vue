<template>
  <v-list>
    <v-list-item
      v-for="item in data"
      :key="item.epci"
      @click="$emit('select', item)"
    >
      <v-list-item-title>{{ item.label }}</v-list-item-title>

      <v-list-item-subtitle>
        {{ $t('nbMunicipality', item.nbMunicipalities) }}
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
defineEmits<{
  (e: 'select', piic: IPiicCollection): void;
}>();
</script>
