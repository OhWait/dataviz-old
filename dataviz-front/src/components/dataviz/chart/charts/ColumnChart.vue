<template>
  <v-chart
    :option="option"
    autoresize
  />
</template>

<script setup lang="ts">
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { BarChart } from 'echarts/charts';
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
} from 'echarts/components';
import VChart from 'vue-echarts';
import { computed } from 'vue';
import { ICartesianResponse } from '@/@types/dataviz/chart';

use([
  CanvasRenderer,
  BarChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  GridComponent,
]);

// Props
const props = defineProps<{
  data: ICartesianResponse;
}>();

// Extraire et trier les années
const xAxis = computed(() => {
  return [
    ...new Set(
      props.data.series.flatMap(serie => serie.data.map(d => d.label))
    ),
  ].sort((a, b) => Number(a) - Number(b)); // Tri chronologique
});

// Computed option
const option = computed(() => ({
  title: {
    text: 'Histogram Chart',
    left: 'center',
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: { type: 'shadow' },
    formatter: (params: any[]) =>
      `${params[0].axisValue}<br/>` +
      params
        .map(p => `${p.seriesName} : ${formatValue(p.value)}`)
        .join('<br/>'),
  },
  legend: {
    left: 'center',
    bottom: 0,
  },
  xAxis: {
    type: 'category',
    data: xAxis.value,
  },
  yAxis: {
    type: 'value',
    axisLabel: {
      formatter: (value: number) => formatValue(value),
    },
  },
  series: props.data.series.map(serie => ({
    name: serie.label || 'Unknown',
    type: 'bar',
    data: xAxis.value.map(x => {
      const point = serie.data.find(d => d.label === x);
      return point ? Math.ceil(point.y) : 0;
    }),
  })),
}));

// Formatter
const formatValue = (value: number) =>
  Math.ceil(value).toLocaleString('fr-FR').replace(/\./g, ',');
</script>
