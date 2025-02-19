<template>
  <v-navigation-drawer
    :model-value="drawer"
    :rail="rail"
    @update:model-value="emit('update:drawer', $event)"
  >
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('chart.drawer.visualizations') }}</span>
        <v-btn
          icon="mdi-chevron-double-left"
          variant="text"
          @click="toggleDrawer(true)"
        />
      </div>
    </template>

    <template v-else>
      <div
        class="bg-blue-grey-lighten-5 position-sticky top-0 border-b-sm"
        :style="{ zIndex: 1 }"
      >
        <div class="d-flex justify-space-between align-center px-3 py-2">
          <span>{{ $t('chart.drawer.visualizations') }}</span>
          <v-btn
            icon="mdi-chevron-double-left"
            variant="text"
            @click.stop="toggleDrawer(false)"
          />
        </div>
      </div>

      <ViewForm
        :current-view="currentView"
        @change-view="handleViewChange"
      />

      <v-divider />

      <VisualisationFormWrapper
        v-if="currentView && dataset && payload"
        :current-view="currentView"
        :payload="payload"
        :dataset="dataset"
        @submit="handleSubmit"
      />
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { IDataset } from '@/@types/dataviz/dataset';
import {
  ICartesianForm,
  IPolarForm,
  TChartForm,
  View,
} from '@/@types/dataviz/chart';
import ViewForm from '../form/ViewForm.vue';
import VisualisationFormWrapper from '../form/VisualisationFormWrapper.vue';

// Props
const props = defineProps<{
  drawer: boolean;
  rail: boolean;
  currentView: View | null;
  payload?: IPolarForm | ICartesianForm;
  dataset?: IDataset;
}>();

// Emits
const emit = defineEmits<{
  (e: 'update:drawer', state: boolean): void;
  (e: 'changeView', view: View): void;
  (e: 'submit', payload: TChartForm): void;
}>();

// Methods
const toggleDrawer = (state: boolean) => emit('update:drawer', state);
const handleViewChange = (view: View) => emit('changeView', view);
const handleSubmit = (payload: TChartForm) =>
  emit('submit', { ...payload, filters: props.payload!.filters });
</script>
