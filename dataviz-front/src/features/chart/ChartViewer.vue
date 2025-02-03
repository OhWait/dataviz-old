<template>
  <pre v-if="chart">{{ chart }}</pre>
  <v-img v-else class="mx-auto h-100" :src="imageSrc" max-width="300" />
</template>

<script setup lang="ts">
import { ChartStore, View } from '@/@types/chart';
import { Chart } from '@/@types/chart/store';
import { useStore } from '@/store';
import { computed } from 'vue';

const store = useStore();

const props = defineProps({
  uuid: {
    type: String,
    required: true,
  },
});

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

// Computed
const currentView = computed<View | null>(
  () => store.getters[ChartStore.GET_VISUALIZATION_VIEW]
);

const imageSrc = computed(() =>
  currentView.value ? images[currentView.value] : images[View.Histogram]
);

const chart = computed<Chart | null>(() =>
  store.getters[ChartStore.GET_CHART](props.uuid)
);
</script>
