<template>
  <component
    v-if="chart && chart.response && chart.response.view"
    :is="chartComponents[chart.response.view]"
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
import { viewList } from '@/utils/viewList';
import PieChart from './PieChart.vue';
import LineChart from './LineChart.vue';
import StackedColumnChart from './StackedColumnChart.vue';
import StackedBarChart from './StackedBarChart.vue';
import ColumnChart from './ColumnChart.vue';
import BarChart from './BarChart.vue';

// Props
const props = defineProps<{
  chart: TChart | null;
  response?: TChartResponse | null;
}>();

// Setup
const chartComponents: Record<View, any> = {
  [View.PieChart]: PieChart,
  [View.DonutChart]: PieChart,
  [View.ColumnChart]: ColumnChart,
  [View.StackedColumnChart]: StackedColumnChart,
  [View.BarChart]: BarChart,
  [View.StackedBarChart]: StackedBarChart,
  [View.LineChart]: LineChart,
};

// Computed
const imageSrc = computed(
  () =>
    viewList.find(v => v.type === props.chart?.view)?.preview ||
    viewList.at(0)?.preview
);
</script>
