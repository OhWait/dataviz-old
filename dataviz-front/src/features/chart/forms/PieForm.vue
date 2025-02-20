<template>
  <v-container>
    <v-form>
      <!-- Select for Values -->
      <DataEntryPicker
        v-model="polar.values.dataEntry"
        @update:model-value="onValuesDataEntryChange"
      />

      <ColumnPicker
        v-model="polar.values.column"
        :label="$t('chart.form.polar.values')"
        :data-entry="valuesDataEntry"
        @update:model-value="onValuesColumnChange"
      />

      <OperationPicker
        v-model="polar.values.operation"
        :data-type="dataTypeSelected"
        @update:model-value="onValuesOperationChange"
      />

      <br />

      <!-- Select for Series -->
      <DataEntryPicker
        v-model="polar.serie.dataEntry"
        @update:model-value="onSeriesDataEntryChange"
      />

      <ColumnPicker
        v-model="polar.serie.column"
        :label="$t('chart.form.polar.series')"
        @update:model-value="onSeriesColumnChange"
        :data-entry="seriesDataEntry"
      />

      <v-btn block @click="submitPolar">Envoyer</v-btn>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { computed, onBeforeMount } from 'vue';
import DataEntryPicker from './inputs/DataEntryPicker.vue';
import ColumnPicker from './inputs/ColumnPicker.vue';
import OperationPicker from './inputs/OperationPicker.vue';
import { IPolarForm, Operation } from '@/@types/dataviz/chart';
import { useChartStore } from '@/store/chartStore';
import { IDataset } from '@/@types/dataviz/dataset';
import { IMetaColumn } from '@/@types/dataviz/column';

// Store
const chartStore = useChartStore();

// Computed properties
/** @ts-ignore */
const dataset = computed<IDataset>(() => chartStore.getDatasetModel);
/** @ts-ignore */
const uuid = computed<string>(() => chartStore.getUuid);
/** @ts-ignore */
const polar = computed<IPolarForm>(() => chartStore.getCurrentPolarForm);

const findEntryBySlug = (slug: string) => dataset.value.dataEntries.find(entry => entry.slug === slug);

/** @ts-ignore */
const valuesDataEntry = computed<IDataEntry>(() => findEntryBySlug(polar.value.values.dataEntry));
/** @ts-ignore */
const seriesDataEntry = computed<IDataEntry>(() => findEntryBySlug(polar.value.serie.dataEntry));

const dataTypeSelected = computed(() =>
  valuesDataEntry.value?.columns.find(
    (c: IMetaColumn) => c.columnName === polar.value.values.column
  )?.dataType
);

// Events
const onValuesDataEntryChange = (dataEntry: string) => {
  if (polar.value) {
    polar.value.values = { dataEntry, operation: null, column: null };
  }
};

const onValuesColumnChange = (column: string) => {
  if (polar.value) {
    polar.value.values.column = column;
    polar.value.values.operation = null;
  }
};

const onValuesOperationChange = (operation: Operation) => {
  if (polar.value) {
    polar.value.values.operation = operation;
  }
};

const onSeriesDataEntryChange = (dataEntry: string) => {
  if (polar.value) {
    polar.value.serie = { dataEntry, column: null };
  }
};

const onSeriesColumnChange = (column: string) => {
  if (polar.value) {
    polar.value.serie.column = column;
  }
};

const submitPolar = () => {
  if (uuid.value && dataset.value && polar.value) {
    chartStore.postPolar(uuid.value, dataset.value.slug, polar.value);
  }
};

onBeforeMount(() => {
  if (chartStore.getDatasetModel) {
    chartStore.initPolar();
  }
});
</script>
