<template>
  <component
    v-if="currentView"
    :is="formComponents[currentView]"
    v-bind="props"
  />
</template>

<script setup lang="ts">
import { View } from '@/@types/dataviz/chart';
import PieForm from './PieForm.vue';
import { ICartesianForm, IPolarForm } from '@/store/graphStore';
import { IDataset } from '@/@types/dataviz/dataset';

// Props
const props = defineProps<{
  currentView: View | null;
  payload: IPolarForm | ICartesianForm;
  dataset: IDataset;
}>();

const formComponents: Record<View, any> = {
  [View.Pie]: PieForm,
  [View.Histogram]: PieForm, // TODO
  [View.StackedHistogram]: PieForm, // TODO
  [View.Bar]: PieForm, // TODO
  [View.StackedBar]: PieForm, // TODO
  [View.Line]: PieForm, // TODO
};
</script>
