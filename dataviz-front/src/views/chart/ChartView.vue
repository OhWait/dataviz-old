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
    @update:drawer="updateDatasetDrawer"
    @change-dataset="setActiveDataset"
  />

  <VisualizationDrawer
    v-if="currentDataset"
    :drawer="drawers.visualization.drawer"
    :rail="drawers.visualization.rail"
    :current-view="drawers.visualization.view"
    :payload="chart?.payload"
    :dataset="chart?.dataset"
    @update:drawer="updateVisualisationDrawer"
    @change-view="setActiveView"
  />
</template>

<script setup lang="ts">
import { View } from '@/@types/dataviz/chart';
import { useGraphStore } from '@/store/graphStore';
import { useDatasetStore } from '@/store/datasetStore';
import ThemeDrawer from '@/components/dataviz/chart/navigation/ThemeDrawer.vue';
import DatasetDrawer from '@/components/dataviz/chart/navigation/DatasetDrawer.vue';
import VisualizationDrawer from '@/components/dataviz/chart/navigation/VisualizationDrawer.vue';
import { v4 as uuidv4 } from 'uuid';
import { computed } from 'vue';

// Stores
const graphStore = useGraphStore();
const datasetStore = useDatasetStore();

// Computed
const uuid = uuidv4();
const datasets = computed(() => datasetStore.getCollectionMembers);
const isLoadingDataset = computed(() => datasetStore.getCollectionLoading);
const drawers = computed(() => graphStore.getDrawers);
const currentDataset = computed(() => graphStore.getDataset(uuid));
const chart = computed(() => graphStore.getChart(uuid));

// Methods
const setActiveTheme = (theme: string) => {
  datasetStore.fetchCollection({ themes: [theme], dataProvider: true });
  graphStore.setActiveTheme(theme);
};

const updateDatasetDrawer = (show: boolean) =>
  graphStore.toggleDrawer('dataset', show);

const updateVisualisationDrawer = (show: boolean) =>
  graphStore.toggleDrawer('visualization', show);

const setActiveDataset = async (datasetSlug: string) => {
  const dataset = await datasetStore.fetchItem(datasetSlug);
  graphStore.initChart(uuid, dataset).setDataset(dataset);
};

const setActiveView = (view: View) =>
  graphStore.updateChart(uuid, view).setDrawerView(view);
</script>
