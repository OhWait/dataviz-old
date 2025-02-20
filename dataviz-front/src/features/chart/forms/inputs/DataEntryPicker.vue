<template>
  <v-select
    v-if="hasMultipleDataEntries"
    :model-value="modelValue"
    :items="dataEntryOptions"
    :label="$t('chart.form.data_entry')"
    item-title="text"
    item-value="value"
    variant="underlined"
    @update:model-value="updateValue"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useChartStore } from '@/store/chartStore';

// Props
defineProps({
  modelValue: {
    type: String as () => string | null,
    default: null,
  },
});

// Emit
const emit = defineEmits(['update:modelValue']);

// Store
const chartStore = useChartStore();
const dataset = computed(() => chartStore.getDatasetModel);
const hasMultipleDataEntries = computed(() => chartStore.hasMultipleEntries);

// Data Entry Options
const dataEntryOptions = computed(() =>
  dataset.value!.dataEntries.map(entry => ({
    text: entry.title,
    value: entry.slug,
  }))
);

const updateValue = (value: string) => {
  emit('update:modelValue', value);
};
</script>
