<template>
  <ThemeDrawer />
  <DatasetDrawer />
  <VisualizationDrawer />
  <FilterDrawer />
  <ChartViewer v-if="uuid" :uuid="uuid" />
</template>

<script setup lang="ts">
import DatasetDrawer from '@/features/chart/navigation/DatasetDrawer.vue';
import ThemeDrawer from '@/features/chart/navigation/ThemeDrawer.vue';
import VisualizationDrawer from '@/features/chart/navigation/VisualizationDrawer.vue';
import FilterDrawer from '@/features/chart/navigation/FilterDrawer.vue';
import ChartViewer from '@/features/chart/ChartViewer.vue';
import { computed, onBeforeMount } from 'vue';
import { useChartStore } from '@/store/chartStore';

// Store
const store = useChartStore();

// Computed properties
const uuid = computed(() => store.getUuid);

// Lifecycle hook
onBeforeMount(() => store.initSingleChart());
</script>
