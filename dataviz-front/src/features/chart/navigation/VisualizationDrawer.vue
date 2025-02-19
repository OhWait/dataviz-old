<template>
  <v-navigation-drawer v-if="drawer" :rail="rail" @click="showDrawer" permanent>
    <template v-if="rail">
      <div class="vertical-text cursor-pointer bg-blue-grey-lighten-5">
        <span>{{ $t('chart.drawer.visualizations') }}</span>

        <v-icon icon="mdi-chevron-double-left" />
      </div>
    </template>

    <template v-else>
      <div
        class="bg-blue-grey-lighten-5 position-sticky top-0"
        :style="{ zIndex: 1 }"
      >
        <v-list-item :title="$t('chart.drawer.visualizations')">
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

      <ViewPicker />

      <v-divider />

      <VisualizationForm />
    </template>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { ChartStore } from '@/@types/dataviz/chart';
import VisualizationForm from '@/features/chart/forms/VisualizationForm.vue';
import ViewPicker from '@/features/chart/forms/ViewPicker.vue';
import { useStore } from '@/store';
import { computed } from 'vue';

const store = useStore();

// Computed
const drawer = computed<boolean>(
  () => store.getters[ChartStore.GET_VISUALIZATION_DRAWER]
);
const rail = computed<boolean>(
  () => store.getters[ChartStore.GET_VISUALIZATION_RAIL]
);

// Methods
const hideDrawer = () => store.commit(ChartStore.HIDE_VISUALIZATION_DRAWER);
const showDrawer = () => store.commit(ChartStore.SHOW_VISUALIZATION_DRAWER);
</script>
