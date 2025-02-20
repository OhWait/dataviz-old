<template>
  <v-navigation-drawer v-if="drawer" :rail="rail" @click="showDrawer" permanent>
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('chart.drawer.visualizations') }}</span>
        <v-icon icon="mdi-chevron-double-left" />
      </div>
    </template>

    <template v-else>
      <div class="bg-blue-grey-lighten-5 position-sticky top-0" :style="{ zIndex: 1 }">
        <v-list-item :title="$t('chart.drawer.visualizations')">
          <template #append>
            <v-btn icon="mdi-chevron-double-left" variant="text" @click.stop="hideDrawer" />
          </template>
        </v-list-item>
        <v-divider />
      </div>

      <ViewPicker />

      <v-divider />

      <VisualizationForm />
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import VisualizationForm from '@/features/chart/forms/VisualizationForm.vue';
import ViewPicker from '@/features/chart/forms/ViewPicker.vue';
import { useChartStore } from '@/store/chartStore';

// Store
const chartStore = useChartStore();

// Computed properties
const drawer = computed(() => chartStore.getVisualizationDrawer);
const rail = computed(() => chartStore.getVisualizationRail);

// Methods
const hideDrawer = () => chartStore.hideVisualizationDrawer();
const showDrawer = () => chartStore.showVisualizationDrawer();
</script>
