<template>
  <v-navigation-drawer v-model="drawer" :rail="rail" @click="showDrawer">
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('dataset') }}</span>
        <v-icon icon="mdi-chevron-double-left" />
      </div>
    </template>

    <template v-else>
      <div class="bg-blue-grey-lighten-5 position-sticky top-0" :style="{ zIndex: 1 }">
        <v-list-item :title="$t('dataset')">
          <template #append>
            <v-btn icon="mdi-chevron-double-left" variant="text" @click.stop="hideDrawer" />
          </template>
        </v-list-item>
        <v-divider />
      </div>

      <v-list>
        <template v-if="isLoading">
          <v-skeleton-loader v-for="n in 5" :key="n" type="list-item,list-item-two-line,list-item" />
        </template>

        <v-list-item
          v-else
          v-for="dataset in datasets"
          :key="dataset.slug"
          :title="dataset.shortTitle"
          :active="dataset.slug === currentDataset"
          class="wrap-text"
          @click="selectDataset(dataset.slug)"
        />
      </v-list>
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { useChartStore } from '@/store/chartStore';
import { useDatasetStore } from '@/store/datasetStore';
import { computed } from 'vue';

// Stores
const chartStore = useChartStore();
const datasetStore = useDatasetStore();

// Computed properties
const drawer = computed(() => chartStore.getDatasetDrawer);
const rail = computed(() => chartStore.getDatasetRail);
const currentDataset = computed(() => chartStore.getCurrentDataset);
const datasets = computed(() => datasetStore.getCollectionMembers);
const isLoading = computed(() => datasetStore.getCollectionLoading);

// Methods
const hideDrawer = () => chartStore.hideDatasetDrawer();
const showDrawer = () => chartStore.showDatasetDrawer();
const selectDataset = async (datasetSlug: string) => {
  if (datasetSlug !== currentDataset.value) {
    chartStore.resetChart();
    const dataset = await datasetStore.fetchItem(datasetSlug);
    chartStore.setCurrentDataset(dataset);
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
