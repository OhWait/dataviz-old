<template>
  <v-navigation-drawer
    rail
    permanent
    image="https://cdn.vuetifyjs.com/images/backgrounds/bg-2.jpg"
    theme="dark"
  >
    <v-list nav>
      <v-list-item
        v-for="theme in themes"
        :key="theme.slug"
        :prepend-icon="theme.icon"
        :active="theme.slug === currentTheme"
        @click="selectTheme(theme.slug)"
      >
        <v-tooltip :text="theme.title" activator="parent" location="end" />
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { themeIconList } from '@/utils/themeIconList';
import { useChartStore } from '@/store/chartStore';
import { useDatasetStore } from '@/store/datasetStore';

// Stores
const chartStore = useChartStore();
const datasetStore = useDatasetStore();

// State
const themes = themeIconList.filter(t => t.active);

// Computed properties
const currentTheme = computed(() => chartStore.getCurrentTheme);

// Methods
const selectTheme = (theme: string) => {
  if (theme !== currentTheme.value) {
    datasetStore.fetchCollection({
      themes: [theme],
      dataProvider: true,
    });
  }

  chartStore.setTheme(theme);
};
</script>
