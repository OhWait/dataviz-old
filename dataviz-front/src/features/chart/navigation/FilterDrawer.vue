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
import { ChartStore, View } from '@/@types/dataviz/chart';
import { useStore } from '@/store';
import { computed } from 'vue';
import FilterForm from '../forms/FilterForm.vue';

const store = useStore();

// Computed
const drawer = computed(() => store.getters[ChartStore.GET_FILTERS_DRAWER]);
const rail = computed(() => store.getters[ChartStore.GET_FILTERS_RAIL]);
const view = computed<View | null>(
  () => store.getters[ChartStore.GET_VISUALIZATION_VIEW]
);

// Methods
const hideDrawer = () => store.commit(ChartStore.HIDE_FILTERS_DRAWER);
const showDrawer = () => store.commit(ChartStore.SHOW_FILTERS_DRAWER);
</script>
