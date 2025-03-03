<template>
  <v-chart
    :option="option"
    autoresize
  />
</template>

<script setup lang="ts">
import { use } from 'echarts/core';
import { CanvasRenderer } from 'echarts/renderers';
import { PieChart } from 'echarts/charts';
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
} from 'echarts/components';
import VChart from 'vue-echarts';
import { computed } from 'vue';
import { IPolarResponse } from '@/@types/dataviz/chart';

use([
  CanvasRenderer,
  PieChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
]);

// Props
const props = defineProps<{
  data: IPolarResponse;
}>();

// Computed
const option = computed(() => ({
  title: {
    text: 'Pie Chart',
    left: 'center',
  },
  tooltip: {
    trigger: 'item',
    formatter: (params: { name: string; value: number; percent: number }) =>
      `${params.name} : ${formatValue(params.value)} (${params.percent.toFixed(2).replace('.', ',')}%)`,
  },
  legend: {
    orient: 'horizontal',
    left: 'center',
    top: 'bottom',
    data: props.data.series.flatMap(serie =>
      serie.data.map(d => d.label || 'Unknown')
    ),
  },
  series: props.data.series.map(serie => ({
    name: serie.label || 'Unknown',
    type: 'pie',
    center: ['50%', '50%'],
    data: serie.data.map(d => ({
      value: Math.ceil(d.y),
      name: d.label || 'Unknown',
    })),
    emphasis: {
      itemStyle: {
        shadowBlur: 10,
        shadowOffsetX: 0,
        shadowColor: 'rgba(0, 0, 0, 0.5)',
      },
    },
  })),
}));

// Methods
const formatValue = (value: number) =>
  Math.ceil(value).toLocaleString('fr-FR').replace(/\./g, ',');
</script>