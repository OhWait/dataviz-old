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
    @submit="handleChartSubmit"
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

  <ChartViewer
    :view="drawers.visualization.view"
    :chart="chart"
    :response="chart?.response"
  />
</template>

<script setup lang="ts">
import { TDrawerKey, IFilter, View, TChartForm } from '@/@types/dataviz/chart';
import { useDatasetStore } from '@/store/datasetStore';
import { useChartStore } from '@/store/chartStore';
import ThemeDrawer from '@/components/dataviz/chart/navigation/ThemeDrawer.vue';
import DatasetDrawer from '@/components/dataviz/chart/navigation/DatasetDrawer.vue';
import VisualizationDrawer from '@/components/dataviz/chart/navigation/VisualizationDrawer.vue';
import FilterDrawer from '@/components/dataviz/chart/navigation/FilterDrawer.vue';
import ChartViewer from '@/components/dataviz/chart/ChartViewer.vue';
import { computed, reactive } from 'vue';
import { v4 as uuidv4 } from 'uuid';

const uuid = uuidv4();

// Stores
const chartStore = useChartStore();
const datasetStore = useDatasetStore();

// State réactif pour éviter un `computed` recalculé inutilement
const drawers = reactive(chartStore.getDrawers);

// Computed
const datasets = computed(() => datasetStore.getCollectionMembers);
const isLoadingDataset = computed(() => datasetStore.getCollectionLoading);
const currentDataset = computed(() => chartStore.getDataset(uuid));
const chart = computed(() => chartStore.getChart(uuid));

// Methods
const updateDrawer = (key: TDrawerKey, state: boolean) =>
  chartStore.toggleDrawer(key, state);

const setActiveTheme = (theme: string) => {
  datasetStore.fetchCollection({ themes: [theme], dataProvider: true });
  chartStore.setActiveTheme(theme);
};

const setActiveDataset = async (datasetSlug: string) => {
  const dataset = await datasetStore.fetchItem(datasetSlug);
  chartStore.initChart(uuid, dataset).setDrawerDataset(dataset);
};

const setActiveView = (view: View) =>
  chartStore.updateChart(uuid, view).setDrawerView(view);

const updateFilters = (filters: IFilter[]) =>
  chartStore.updateFilters(uuid, filters);

const handleChartSubmit = (form: TChartForm) =>
  chartStore.postForm(currentDataset.value?.slug!, uuid, form);
</script>
