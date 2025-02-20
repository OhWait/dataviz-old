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
import { ChartStore } from '@/@types/dataviz/chart';
import { useDatasetStore } from '@/store/datasetStore';
import { themeIconList } from '@/utils/themeIconList';
import { useStore } from '@/store';
import { computed } from 'vue';

const store = useStore();
const datasetStore = useDatasetStore();

// State
const themes = themeIconList.filter(t => t.active);

// Getters
const currentTheme = computed<string>(
  () => store.getters[ChartStore.GET_CURRENT_THEME]
);

// Methods
const selectTheme = (theme: string) => {
  if (theme !== currentTheme.value) {
    datasetStore.fetchCollection({
      themes: [theme],
      dataProvider: true,
    });
  }

  store.commit(ChartStore.SET_THEME, theme);
};
</script>
