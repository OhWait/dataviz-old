<template>
  <v-select
    :model-value="modelValue"
    :items="items"
    :label="$t('chart.form.data_entry')"
    item-title="text"
    item-value="value"
    variant="underlined"
    @update:model-value="emit('update:modelValue', $event)"
  />
</template>

<script setup lang="ts">
import { IDataset } from '@/@types/dataviz/dataset';
import { computed } from 'vue';

// Props
const props = defineProps<{ modelValue: string | null; dataset: IDataset }>();

// Emit
const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>();

// Computed
const items = computed(() =>
  props.dataset.dataEntries.map(entry => ({
    text: entry.title,
    value: entry.slug,
  }))
);
</script>
