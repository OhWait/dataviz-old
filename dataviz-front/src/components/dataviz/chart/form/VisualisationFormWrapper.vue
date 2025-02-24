<template>
  <component
    v-if="currentView"
    :is="formComponents[currentView]"
    v-bind="props"
    @submit="submitForm"
  />
</template>

<script setup lang="ts">
import { ICartesianForm, IPolarForm, TChartForm, View } from '@/@types/dataviz/chart';
import PieForm from './PieForm.vue';
import { IDataset } from '@/@types/dataviz/dataset';

// Props
const props = defineProps<{
  currentView: View | null;
  payload: IPolarForm | ICartesianForm;
  dataset: IDataset;
}>();

// Emits
const emit = defineEmits<{
  (e: 'submit', payload: TChartForm): void;
}>();

const formComponents: Record<View, any> = {
  [View.Pie]: PieForm,
  [View.Histogram]: PieForm, // TODO
  [View.StackedHistogram]: PieForm, // TODO
  [View.Bar]: PieForm, // TODO
  [View.StackedBar]: PieForm, // TODO
  [View.Line]: PieForm, // TODO
};

// Methods
const submitForm = (payload: TChartForm) => emit('submit', payload);
</script>
