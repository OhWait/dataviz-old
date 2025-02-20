<template>
  <pre v-if="chart">{{ chart }}</pre>
  <v-img v-else class="mx-auto h-100" :src="imageSrc" max-width="300" />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { View } from '@/@types/dataviz/chart/index.js';
import { useChartStore } from '@/store/chartStore';

const props = defineProps({
  uuid: {
    type: String,
    required: true,
  },
});

// Store
const chartStore = useChartStore();

// State
const imgPath = '/media/charts/preview';
const images = {
  [View.Pie]: `${imgPath}/pie.svg`,
  [View.Histogram]: `${imgPath}/bar_vertical.svg`,
  [View.StackedHistogram]: `${imgPath}/bar_stacked_vertical.svg`,
  [View.Bar]: `${imgPath}/bar_horizontal.svg`,
  [View.StackedBar]: `${imgPath}/bar_stacked_horizontal.svg`,
  [View.Line]: `${imgPath}/line.svg`,
};

// Computed properties
const currentView = computed(() => chartStore.getVisualizationView);
const imageSrc = computed(() => images[currentView.value || View.Histogram]);
const chart = computed(() => chartStore.getChart(props.uuid));
</script>
