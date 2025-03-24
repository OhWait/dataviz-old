<template>
  <v-list>
    <v-list-item
      v-for="item in data"
      :key="item.dep"
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
import { IDepartmentCollection } from '@/@types/dataviz/administrativeDivision';

// Props
defineProps<{
  data: IDepartmentCollection[];
}>();

// Emits
defineEmits<{
  (e: 'select', department: IDepartmentCollection): void;
}>();
</script>
