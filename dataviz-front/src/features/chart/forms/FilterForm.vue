<template>
  <div
    class="position-sticky bg-white pa-3"
    :style="{ zIndex: 1, top: '57px' }"
  >
    <v-btn @click="addFilter" class="mb-4" block>
      <v-icon icon="mdi-plus" class="mr-2" />
      {{ $t('chart.form.filter.add_filter') }}
    </v-btn>
  </div>

  <v-container>
    <v-form>
      <v-card v-for="(filter, index) in filters" :key="index" class="mb-4">
        <v-card-text class="pt-5 pb-0">
          <DataEntryPicker
            v-model="filter.dataEntry"
            density="compact"
            @update:model-value="onDataEntryChange(index)"
          />

          <ColumnPicker
            v-model="filter.column"
            :label="$t('chart.form.filter.column')"
            :data-entry="filter.entry"
            density="compact"
            @update:model-value="onColumnChange(index)"
          />

          <v-select
            v-model="filter.values"
            :disabled="!filter.dataEntry || !filter.column"
            :items="filter.valueOptions"
            :label="$t('chart.form.filter.values')"
            item-title="text"
            item-value="value"
            variant="underlined"
            density="compact"
            multiple
            chips
            required
          >
            <template #item="{ props }">
              <v-list-item v-bind="props" max-width="400" class="wrap-text" />
            </template>
          </v-select>
        </v-card-text>

        <v-card-actions class="d-flex justify-space-around pa-0">
          <v-tooltip :text="$t('chart.form.filter.clear')">
            <template #activator="{ props }">
              <v-btn
                icon="mdi-close"
                @click="clearFilter(index)"
                variant="text"
                v-bind="props"
                siz
              />
            </template>
          </v-tooltip>

          <v-tooltip :text="$t('chart.form.filter.delete')">
            <template #activator="{ props }">
              <v-btn
                icon="mdi-delete"
                @click="removeFilter(index)"
                variant="text"
                v-bind="props"
              />
            </template>
          </v-tooltip>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useStore } from '@/store';
import { ChartStore } from '@/@types/chart';
import { IDataset } from '@/@types/dataset';
import { IDataEntry } from '@/@types/dataEntry';
import DataEntryPicker from './inputs/DataEntryPicker.vue';
import ColumnPicker from './inputs/ColumnPicker.vue';
import { IFilter } from '@/@types/chart/store';

// Store
const store = useStore();

// Computed
const dataset = computed<IDataset>(
  () => store.getters[ChartStore.GET_DATASET_MODEL]
);
const defaultEntry = computed<IDataEntry>(
  () => store.getters[ChartStore.GET_DEFAULT_ENTRY]
);

// State
const filters = computed<IFilter[]>(
  () => store.getters[ChartStore.GET_CURRENT_FILTERS]
);

const addFilter = () =>
  filters.value.push({
    entry: defaultEntry.value,
    dataEntry: defaultEntry.value.slug,
    column: null,
    values: [],
    valueOptions: [],
  });

const removeFilter = (index: number) => {
  filters.value.splice(index, 1);
};

const clearFilter = (index: number) => {
  filters.value[index] = {
    ...filters.value[index],
    column: null,
    values: [],
    valueOptions: [],
  };
};

const onDataEntryChange = (index: number) => {
  const entry = dataset.value.dataEntries.find(
    e => e.slug === filters.value[index].dataEntry
  );

  if (entry) {
    filters.value[index].entry = entry;
    filters.value[index].column = null;
    filters.value[index].values = [];
    filters.value[index].valueOptions = [];
  }
};

const onColumnChange = (index: number) => {
  const entry = dataset.value.dataEntries.find(
    e => e.slug === filters.value[index].dataEntry
  );

  // Shall never happen
  if (!entry) {
    return;
  }

  const column = entry.columns.find(
    col => col.columnName === filters.value[index].column
  );

  // Shall never happen
  if (!column) {
    filters.value[index].valueOptions = [];
    return;
  }

  filters.value[index].valueOptions = column.values.map(v => ({
    text: v.label,
    value: v.value,
  }));
};
</script>

<style>
.wrap-text .v-list-item-title {
  white-space: normal;
  word-wrap: break-word;
}
</style>
