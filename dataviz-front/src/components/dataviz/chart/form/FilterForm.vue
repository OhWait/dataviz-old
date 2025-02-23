<template>
  <div
    class="position-sticky bg-white pa-3"
    :style="{ zIndex: 1, top: '57px' }"
  >
    <v-btn
      @click="addFilter"
      class="mb-4"
      block
    >
      <v-icon
        icon="mdi-plus"
        class="mr-2"
      />
      {{ $t('chart.form.filter.add_filter') }}
    </v-btn>
  </div>

  <v-container>
    <v-form>
      <v-card
        v-for="(filter, index) in filters"
        :key="index"
        class="mb-4"
      >
        <v-card-text class="pt-5 pb-0">
          <DataEntryPicker
            v-if="hasMultipleDataEntries"
            v-model="filter.dataEntry"
            :dataset="dataset"
            @update:model-value="updateFilter(index)"
          />

          <ColumnPicker
            v-model="filter.column"
            :label="$t('chart.form.filter.column')"
            :data-entry="filter.entry"
            density="compact"
            @update:model-value="updateFilter(index)"
          />

          <v-select
            v-model="filter.values"
            :disabled="!filter.column"
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
              <v-list-item
                v-bind="props"
                class="wrap-text"
              />
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
import DataEntryPicker from './input/DataEntryPicker.vue';
import ColumnPicker from './input/ColumnPicker.vue';
import { ref, computed, watchEffect } from 'vue';
import { IFilter } from '@/store/graphStore';
import { IDataset } from '@/@types/dataviz/dataset';

// Props & Emits
const props = defineProps<{
  filters: IFilter[];
  dataset: IDataset;
}>();
const emit = defineEmits<{ (e: 'update:filters', filters: IFilter[]): void }>();

// Reactive Filters
const filters = ref([...props.filters]);

// Computed properties
const dataEntries = computed(() => props.dataset.dataEntries);
const hasMultipleDataEntries = computed(() => dataEntries.value.length > 1);
const defaultEntry = computed(() => dataEntries.value.at(0));

// Watch for prop changes and update local filters
watchEffect(() => (filters.value = [...props.filters]));

// Methods
const addFilter = () => {
  if (!defaultEntry.value) return;

  filters.value.push({
    entry: defaultEntry.value,
    dataEntry: defaultEntry.value.slug,
    column: null,
    values: [],
    valueOptions: [],
  });

  emit('update:filters', filters.value);
};

const removeFilter = (index: number) => {
  filters.value.splice(index, 1);
  emit('update:filters', filters.value);
};

const clearFilter = (index: number) => {
  const filter = filters.value[index];
  if (!filter) return;
  Object.assign(filter, { column: null, values: [], valueOptions: [] });
  emit('update:filters', filters.value);
};

const updateFilter = (index: number) => {
  const filter = filters.value[index];
  if (!filter) return;

  const entry = dataEntries.value.find(e => e.slug === filter.dataEntry);
  if (!entry) {
    console.warn(`Data entry not found: ${filter.dataEntry}`);
    return;
  }

  filter.entry = entry;
  filter.valueOptions =
    entry.columns
      .find(col => col.columnName === filter.column)
      ?.values.map(v => ({
        text: v.label,
        value: v.value,
      })) || [];

  emit('update:filters', filters.value);
};
</script>

<style>
.wrap-text .v-list-item-title {
  white-space: normal;
  word-wrap: break-word;
}
</style>
