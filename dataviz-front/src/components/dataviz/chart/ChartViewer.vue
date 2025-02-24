<template>
  <pre v-if="response">{{ response }}</pre>
  <pre v-if="chart?.payload">{{ chart.payload }}</pre>

  <v-img
    v-else
    class="mx-auto h-100"
    :src="imageSrc"
    max-width="300"
  />
</template>

<script setup lang="ts">
import { TChart, TResponse, View } from '@/@types/dataviz/chart/index.js';
import { chartImages } from '@/utils/chart/chartImage';
import { computed } from 'vue';

const props = defineProps<{
  view: View | null;
  chart: TChart | null;
  response?: TResponse | null;
}>();

// Computed
const imageSrc = computed(() => chartImages[props.view || View.Histogram]);
</script>
