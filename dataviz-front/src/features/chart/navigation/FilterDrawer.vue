<template>
  <v-navigation-drawer
    v-if="drawer && view"
    :rail="rail"
    @click="showDrawer"
    permanent
  >
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('chart.drawer.filters') }}</span>
        <v-icon icon="mdi-chevron-double-left" />
      </div>
    </template>

    <template v-else>
      <div
        class="bg-blue-grey-lighten-5 position-sticky top-0"
        :style="{ zIndex: 1 }"
      >
        <v-list-item :title="$t('chart.drawer.filters')">
          <template #append>
            <v-btn
              icon="mdi-chevron-double-left"
              variant="text"
              @click.stop="hideDrawer"
            />
          </template>
        </v-list-item>
        <v-divider />
      </div>

      <FilterForm />
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import FilterForm from '../forms/FilterForm.vue';
import { useChartStore } from '@/store/chartStore';

// Store
const chartStore = useChartStore();

// Computed properties
const drawer = computed(() => chartStore.getFiltersDrawer);
const rail = computed(() => chartStore.getFiltersRail);
const view = computed(() => chartStore.getVisualizationView);

// Methods
const hideDrawer = () => chartStore.hideFiltersDrawer();
const showDrawer = () => chartStore.showFiltersDrawer();
</script>
