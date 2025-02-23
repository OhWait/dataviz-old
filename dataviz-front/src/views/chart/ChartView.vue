<template>
  <ThemeDrawer
    :current-theme="drawers.theme.currentTheme"
    @change-theme="setActiveTheme"
  />

  <DatasetDrawer
    :drawer="drawers.dataset.drawer"
    :rail="drawers.dataset.rail"
    :current-dataset-slug="drawers.dataset.currentDataset"
    :datasets="datasets"
    :is-loading="isLoadingDataset"
    @update:drawer="updateDrawer('dataset', $event)"
    @change-dataset="setActiveDataset"
  />

  <VisualizationDrawer
    v-if="currentDataset"
    :drawer="drawers.visualization.drawer"
    :rail="drawers.visualization.rail"
    :current-view="drawers.visualization.view"
    :payload="chart?.payload"
    :dataset="chart?.dataset"
    @update:drawer="updateDrawer('visualization', $event)"
    @change-view="setActiveView"
  />

  <FilterDrawer
    v-if="chart?.payload?.filters"
    :drawer="drawers.filter.drawer"
    :rail="drawers.filter.rail"
    :filters="chart.payload.filters"
    :dataset="chart.dataset"
    @update:drawer="updateDrawer('filter', $event)"
    @update:filters="updateFilters($event)"
  />
</template>

<script setup lang="ts">
import { View } from '@/@types/dataviz/chart';
import { IFilter, useGraphStore } from '@/store/graphStore';
import { useDatasetStore } from '@/store/datasetStore';
import ThemeDrawer from '@/components/dataviz/chart/navigation/ThemeDrawer.vue';
import DatasetDrawer from '@/components/dataviz/chart/navigation/DatasetDrawer.vue';
import VisualizationDrawer from '@/components/dataviz/chart/navigation/VisualizationDrawer.vue';
import FilterDrawer from '@/components/dataviz/chart/navigation/FilterDrawer.vue';
import { computed, reactive } from 'vue';
import { v4 as uuidv4 } from 'uuid';

// Stores
const graphStore = useGraphStore();
const datasetStore = useDatasetStore();

const uuid = uuidv4();

// State réactif pour éviter un `computed` recalculé inutilement
const drawers = reactive(graphStore.getDrawers);

// Computed
const datasets = computed(() => datasetStore.getCollectionMembers);
const isLoadingDataset = computed(() => datasetStore.getCollectionLoading);
const currentDataset = computed(() => graphStore.getDataset(uuid));
const chart = computed(() => graphStore.getChart(uuid));

// Methods
const updateDrawer = (
  type: 'dataset' | 'visualization' | 'filter',
  state: boolean
) => {
  graphStore.toggleDrawer(type, state);
};

const setActiveTheme = (theme: string) => {
  datasetStore.fetchCollection({ themes: [theme], dataProvider: true });
  graphStore.setActiveTheme(theme);
};

const setActiveDataset = async (datasetSlug: string) => {
  const dataset = await datasetStore.fetchItem(datasetSlug);
  graphStore.initChart(uuid, dataset);
  graphStore.setDrawerDataset(dataset);
};

const setActiveView = (view: View) => {
  graphStore.updateChart(uuid, view);
  graphStore.setDrawerView(view);
};

const updateFilters = (filters: IFilter[]) => graphStore.updateFilters(uuid, filters);
</script>
