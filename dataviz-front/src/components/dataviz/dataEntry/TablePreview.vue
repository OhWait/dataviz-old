<template>
  <div>
    <v-alert
      v-if="error"
      border="start"
      type="error"
    >
      {{ $t('dataentry.preview.error') }}
    </v-alert>

    <v-data-table-server
      v-else
      :headers="headers"
      :items="items"
      :items-length="500"
      :loading="loading"
      :height="500"
      fixed-header
    >
      <template #bottom></template>
    </v-data-table-server>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue';

// Props
const props = defineProps<{
  items: any[];
  loading: boolean;
  error: Error | null;
}>();

// Emits
const emit = defineEmits(['loadItems']);

// Headers
const headers = computed(() =>
  props.items.length > 0
    ? Object.keys(props.items[0]).map(key => ({ title: key, key }))
    : []
);

// Lifecycle Hook
onMounted(() => emit('loadItems'));
</script>
