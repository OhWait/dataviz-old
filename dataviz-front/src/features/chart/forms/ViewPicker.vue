<template>
  <v-container>
    <div class="chart-grid">
      <div
        class="chart-grid-item cursor-pointer"
        v-for="view in views"
        :key="view.type"
        @click="selectView(view.type)"
        :class="{ active: view.type === currentView }"
      >
        <v-tooltip activator="parent">{{ view.title }}</v-tooltip>
        <v-img :src="view.icon" />
      </div>
    </div>
  </v-container>
</template>

<script setup lang="ts">
import { ChartStore, View, viewList as views } from '@/@types/chart';
import { useStore } from '@/store';
import { computed } from 'vue';

const store = useStore();

// Computed
const currentView = computed<View | null>(
  () => store.getters[ChartStore.GET_VISUALIZATION_VIEW]
);

// Methods
const selectView = (view: View) => store.commit(ChartStore.SET_VIEW, view);
</script>

<style scoped>
.chart-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 5px;
}

.chart-grid-item {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 10px;
}

.active {
  border: 1px solid #e4e4e4;
}

.chart-grid-item:hover {
  background-color: #e4e4e4;
}
</style>
