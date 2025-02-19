<template>
  <ThemeDrawer />
  <DatasetDrawer />
  <VisualizationDrawer />
  <FilterDrawer />
  <ChartViewer :uuid="uuid" />
</template>

<script setup lang="ts">
import DatasetDrawer from '@/features/chart/navigation/DatasetDrawer.vue';
import ThemeDrawer from '@/features/chart/navigation/ThemeDrawer.vue';
import VisualizationDrawer from '@/features/chart/navigation/VisualizationDrawer.vue';
import FilterDrawer from '@/features/chart/navigation/FilterDrawer.vue';
import ChartViewer from '@/features/chart/ChartViewer.vue';
import { useStore } from '@/store';
import { computed, onBeforeMount } from 'vue';
import { ChartStore } from '@/@types/dataviz/chart';

const store = useStore();

const uuid = computed(() => store.getters[ChartStore.GET_UUID]);

onBeforeMount(() => store.commit(ChartStore.INIT_SINGLE_CHART));
</script>
