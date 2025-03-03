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

// Computed option
const categories = computed(() => {
  return [
    ...new Set(
      props.data.series.flatMap(serie => serie.data.map(d => d.label))
    ),
  ];
});

const option = computed(() => ({
  title: {
    text: 'Stacked Bar Chart',
    left: 'center',
  },
  tooltip: {
    trigger: 'axis',
    axisPointer: { type: 'shadow' },
    formatter: (params: any[]) => {
      const category = params[0].axisValue;
      return (
        `${category}<br/>` +
        params
          .map(p => `${p.seriesName} : ${formatValue(p.value)}`)
          .join('<br/>')
      );
    },
  },
  legend: {
    left: 'center',
    bottom: 0,
  },
  grid: {
    left: '3%',
    right: '4%',
    bottom: '10%',
    containLabel: true,
  },
  xAxis: {
    type: 'value', // Axe X = Valeurs
    axisLabel: {
      formatter: (value: number) => formatValue(value),
    },
  },
  yAxis: {
    type: 'category', // Axe Y = Catégories
    data: categories.value,
  },
  series: props.data.series.map(serie => ({
    name: serie.label || 'Unknown',
    type: 'bar',
    stack: 'total',
    data: categories.value.map(category => {
      const point = serie.data.find(d => d.label === category);
      return point ? Math.ceil(point.y) : 0;
    }),
  })),
}));

// Formatter
const formatValue = (value: number) =>
  Math.ceil(value).toLocaleString('fr-FR').replace(/\./g, ',');
</script>
