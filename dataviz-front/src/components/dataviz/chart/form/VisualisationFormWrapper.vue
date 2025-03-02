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
import { IDataset } from '@/@types/dataviz/dataset';
import PieForm from './PieForm.vue';
import CartesianForm from './CartesianForm.vue';

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
  [View.Histogram]: CartesianForm,
  [View.StackedHistogram]: CartesianForm,
  [View.Bar]: CartesianForm,
  [View.StackedBar]: CartesianForm,
  [View.Line]: CartesianForm,
};

// Methods
const submitForm = (payload: TChartForm) => emit('submit', payload);
</script>
