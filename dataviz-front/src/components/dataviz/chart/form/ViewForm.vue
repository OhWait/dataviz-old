<template>
  <v-container>
    <div class="chart-grid">
      <div
        class="chart-grid-item cursor-pointer"
        v-for="view in viewList"
        :key="view.type"
        @click="handleViewClick(view.type)"
        :class="{ active: view.type === currentView }"
      >
        <v-tooltip activator="parent">{{ view.title }}</v-tooltip>
        <v-img :src="view.icon" />
      </div>
    </div>
  </v-container>
</template>

<script setup lang="ts">
import { View } from '@/@types/dataviz/chart';
import { viewList } from '@/utils/viewList';

// Props
const props = defineProps<{
  currentView: View | null;
}>();

// Events
const emit = defineEmits<{
  (e: 'changeView', state: View): void;
}>();

// Methods
const handleViewClick = (view: View) => {
  if (view !== props.currentView) {
    emit('changeView', view);
  }
};
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
