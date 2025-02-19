<template>
  <v-navigation-drawer
    v-if="drawer"
    :rail="rail"
    @update:model-value="emit('update:drawer', $event)"
    permanent
  >
    <div
      v-if="rail"
      class="vertical-text cursor-pointer bg-blue-grey-lighten-5"
    >
      <span>{{ $t('chart.drawer.filters') }}</span>
      <v-btn
        icon="mdi-chevron-double-left"
        variant="text"
        @click="toggleDrawer(true)"
      />
    </div>

    <div
      v-else
      class="bg-blue-grey-lighten-5 position-sticky top-0 border-b-sm"
      :style="{ zIndex: 1 }"
    >
      <div class="d-flex justify-space-between align-center px-3 py-2">
        <span>{{ $t('chart.drawer.filters') }}</span>
        <v-btn
          icon="mdi-chevron-double-left"
          variant="text"
          @click.stop="toggleDrawer(false)"
        />
      </div>
    </div>

    <FilterForm
      v-if="!rail"
      :filters="filters"
      :dataset="dataset"
      @update:filters="emit('update:filters', $event)"
    />
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { IFilter } from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import FilterForm from '../form/FilterForm.vue';

// Props
defineProps<{
  drawer: boolean;
  rail: boolean;
  filters: IFilter[];
  dataset: IDataset;
}>();

// Emits
const emit = defineEmits<{
  (e: 'update:drawer', state: boolean): void;
  (e: 'update:filters', filters: IFilter[]): void;
}>();

// Methods
const toggleDrawer = (state: boolean) => emit('update:drawer', state);
</script>
