<template>
  <v-navigation-drawer
    :model-value="drawer"
    :rail="rail"
    @update:model-value="emit('update:drawer', $event)"
  >
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('dataset') }}</span>
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
          <span>{{ $t('dataset') }}</span>
          <v-btn
            icon="mdi-chevron-double-left"
            variant="text"
            @click.stop="toggleDrawer(false)"
          />
        </div>
      </div>

      <v-list>
        <template v-if="isLoading">
          <v-skeleton-loader
            v-for="n in 5"
            :key="n"
            type="list-item,list-item-two-line,list-item"
          />
        </template>

        <v-list-item
          v-else
          v-for="dataset in datasets"
          :key="dataset.slug"
          :title="dataset.shortTitle"
          :active="dataset.slug === currentDatasetSlug"
          class="wrap-text"
          @click="handleDatasetClick(dataset.slug)"
        />
      </v-list>
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';
import { IDatasetCollection } from '@/@types/dataviz/dataset';

// Props
const props = defineProps<{
  drawer: boolean;
  rail: boolean;
  currentDatasetSlug: string | null;
  datasets: IDatasetCollection[];
  isLoading: boolean;
}>();

// Events
const emit = defineEmits<{
  (e: 'update:drawer', state: boolean): void;
  (e: 'changeDataset', datasetSlug: string): void;
}>();

// Methods
const toggleDrawer = (state: boolean) => emit('update:drawer', state);

const handleDatasetClick = (datasetSlug: string) => {
  if (datasetSlug !== props.currentDatasetSlug) {
    emit('changeDataset', datasetSlug);
  }
};
</script>

<style>
.wrap-text .v-list-item-title {
  white-space: normal;
  word-wrap: break-word;
}

.vertical-text {
  writing-mode: vertical-rl;
  transform: rotate(180deg);
  height: 100%;
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding-top: 16px;
  font-size: 16px;
  line-height: 55px;
}

.vertical-text .v-icon {
  margin: 8px 0 8px 0;
}
</style>
