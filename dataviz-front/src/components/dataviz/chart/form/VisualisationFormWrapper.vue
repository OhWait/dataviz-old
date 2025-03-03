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
import PieForm from './PolarForm.vue';
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
  [View.PieChart]: PieForm,
  [View.DonutChart]: PieForm,
  [View.ColumnChart]: CartesianForm,
  [View.StackedColumnChart]: CartesianForm,
  [View.BarChart]: CartesianForm,
  [View.StackedBarChart]: CartesianForm,
  [View.LineChart]: CartesianForm,
};

// Methods
const submitForm = (payload: TChartForm) => emit('submit', payload);
</script>
