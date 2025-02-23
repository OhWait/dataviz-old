<template>
  <v-container>
    <v-form>
      <!-- Select for Values -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="payload.values.dataEntry"
        :dataset="dataset"
      />

      <ColumnPicker
        v-model="payload.values.column"
        :label="$t('chart.form.polar.values')"
        :data-entry="valuesDataEntry"
      />

      <OperationPicker
        v-model="payload.values.operation"
        :data-type="dataType"
      />

      <br />

      <!-- Select for Series -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="payload.serie.dataEntry"
        :dataset="dataset"
      />

      <ColumnPicker
        v-model="payload.serie.column"
        :label="$t('chart.form.polar.series')"
        :data-entry="serieDataEntry"
      />
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import ColumnPicker from './input/ColumnPicker.vue';
import OperationPicker from './input/OperationPicker.vue';
import DataEntryPicker from './input/DataEntryPicker.vue';
import { IDataset } from '@/@types/dataviz/dataset';
import { IPolarForm } from '@/store/graphStore';
import { computed, watch } from 'vue';

// Props
const props = defineProps<{
  payload: IPolarForm;
  dataset: IDataset;
}>();

// Computed
const dataEntries = computed(() => props.dataset.dataEntries);
const hasMultipleDataEntries = computed(() => dataEntries.value.length > 1);
const valuesDataEntry = computed(
  () =>
    dataEntries.value.find(d => d.slug === props.payload.values.dataEntry) ??
    dataEntries.value.at(0)
);
const serieDataEntry = computed(
  () =>
    dataEntries.value.find(d => d.slug === props.payload.serie.dataEntry) ??
    dataEntries.value.at(0)
);
const dataType = computed(
  () =>
    valuesDataEntry.value?.columns.find(
      c => c.columnName === props.payload.values.column
    )?.dataType
);

// Reset column and operation when dataEntry changes
watch(
  () => props.payload.values.dataEntry,
  () => {
    props.payload.values.column = null;
    props.payload.values.operation = null;
  }
);

// Reset operation when column changes
watch(
  () => props.payload.values.column,
  () => (props.payload.values.operation = null)
);
</script>
