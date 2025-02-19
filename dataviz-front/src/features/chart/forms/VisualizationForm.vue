<template>
  <component :is="currentFormComponent" />
</template>

<script setup lang="ts">
import { ChartStore, View } from '@/@types/dataviz/chart';
import { useStore } from '@/store';
import { computed } from 'vue';
import PieForm from './PieForm.vue';
import HistogramForm from './HistogramForm.vue';

const store = useStore();

// State
const formComponents = {
  [View.Pie]: PieForm,
  [View.Histogram]: HistogramForm,
  [View.StackedHistogram]: HistogramForm, // Replace with the correct component
  [View.Bar]: HistogramForm, // Replace with the correct component
  [View.StackedBar]: HistogramForm, // Replace with the correct component
  [View.Line]: HistogramForm, // Replace with the correct component
};

// Computed
const currentView = computed<View | null>(
  () => store.getters[ChartStore.GET_VISUALIZATION_VIEW]
);

const currentFormComponent = computed(() =>
  currentView.value ? formComponents[currentView.value] : null
);
</script>
