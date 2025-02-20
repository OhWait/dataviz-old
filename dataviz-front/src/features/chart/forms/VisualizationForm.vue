<template>
  <component :is="currentFormComponent" />
</template>

<script setup lang="ts">
import PieForm from './PieForm.vue';
import HistogramForm from './HistogramForm.vue';
import { useChartStore } from '@/store/chartStore';
import { View } from '@/@types/dataviz/chart/index.js';
import { computed } from 'vue';

// Store
const chartStore = useChartStore();

// State
const formComponents = {
  [View.Pie]: PieForm,
  [View.Histogram]: HistogramForm,
  [View.StackedHistogram]: HistogramForm, // TODO
  [View.Bar]: HistogramForm, // TODO
  [View.StackedBar]: HistogramForm, // TODO
  [View.Line]: HistogramForm, // TODO
};

// Computed properties
const currentView = computed(() => chartStore.getVisualizationView);
const currentFormComponent = computed(() => formComponents[currentView.value || View.Histogram]);
</script>
