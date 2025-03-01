<template>
  <component
    v-if="chart && chart.response && view"
    :is="chartComponents[view]"
    :data="chart.response"
  />

  <v-img
    v-else
    class="mx-auto h-100"
    :src="imageSrc"
    max-width="300"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { TChart, TChartResponse, View } from '@/@types/dataviz/chart/index.js';
import { chartImages } from '@/utils/chart/chartImage';
import ChartPie from './ChartPie.vue';
import ChartHistogram from './ChartHistogram.vue';
import ChartStackedHistogram from './ChartStackedHistogram.vue';
import ChartBar from './ChartBar.vue';
import ChartStackedBar from './ChartStackedBar.vue';
import ChartLine from './ChartLine.vue';

// Props
const props = defineProps<{
  view?: View | null;
  chart: TChart | null;
  response?: TChartResponse | null;
}>();

// Setup
const chartComponents: Record<View, any> = {
  [View.Pie]: ChartPie,
  [View.Histogram]: ChartHistogram,
  [View.StackedHistogram]: ChartStackedHistogram,
  [View.Bar]: ChartBar,
  [View.StackedBar]: ChartStackedBar,
  [View.Line]: ChartLine,
};

// Computed
const imageSrc = computed(() => chartImages[props.view || View.Pie]);
</script>
