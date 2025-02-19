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

      <v-btn block @click="submitPolar()">Envoyer</v-btn>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { computed, onBeforeMount } from 'vue';
import { useStore } from '@/store';
import { ChartStore } from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import { IDataEntry } from '@/@types/dataviz/dataEntry';
import { Operation } from '@/@types/dataviz/chart/model/payload';
import DataEntryPicker from './inputs/DataEntryPicker.vue';
import ColumnPicker from './inputs/ColumnPicker.vue';
import OperationPicker from './inputs/OperationPicker.vue';
import { IPolarForm } from '@/@types/dataviz/chart/store';

// Store
const store = useStore();

// Computed
const dataset = computed<IDataset>(
  () => store.getters[ChartStore.GET_DATASET_MODEL]
);
const uuid = computed<string>(() => store.getters[ChartStore.GET_UUID]);
const polar = computed<IPolarForm>(
  () => store.getters[ChartStore.GET_CURRENT_PIE_FORM]
);

const findEntryBySlug = (slug: string): IDataEntry =>
  dataset.value.dataEntries.find(entry => entry.slug === slug)!;

const valuesDataEntry = computed<IDataEntry>(() =>
  findEntryBySlug(polar.value.values.dataEntry)
);

const seriesDataEntry = computed<IDataEntry>(() =>
  findEntryBySlug(polar.value.serie.dataEntry)
);

const dataTypeSelected = computed(
  () =>
    valuesDataEntry.value?.columns.find(
      c => c.columnName === polar.value.values.column
    )?.dataType
);

// Events
const onValuesDataEntryChange = (dataEntry: string) =>
  (polar.value.values = { dataEntry, operation: null, column: null });

const onValuesColumnChange = (column: string) => {
  polar.value.values.column = column;
  polar.value.values.operation = null;
};

const onValuesOperationChange = (operation: Operation) =>
  (polar.value.values.operation = operation);

const onSeriesDataEntryChange = (dataEntry: string) =>
  (polar.value.serie = { dataEntry, column: null });

const onSeriesColumnChange = (column: string) =>
  (polar.value.serie.column = column);

const submitPolar = () =>
  store.dispatch(ChartStore.POST_POLAR, {
    uuid: uuid.value,
    slug: dataset.value.slug,
    polar: polar.value,
  });

onBeforeMount(() => store.commit(ChartStore.INIT_POLAR));
</script>
