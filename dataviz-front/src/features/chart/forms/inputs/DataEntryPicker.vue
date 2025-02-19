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
import { useStore } from '@/store';
import { ChartStore } from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';

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
const store = useStore();
const dataset = computed<IDataset>(
  () => store.getters[ChartStore.GET_DATASET_MODEL]
);
const hasMultipleDataEntries = computed<boolean>(
  () => store.getters[ChartStore.HAS_MULTIPLE_ENTRIES]
);

// Data Entry Options
const dataEntryOptions = computed(() =>
  dataset.value.dataEntries.map(entry => ({
    text: entry.title,
    value: entry.slug,
  }))
);

const updateValue = (value: string) => {
  emit('update:modelValue', value);
};
</script>
