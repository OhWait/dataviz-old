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
        @click="handleThemeClick(theme.slug)"
      >
        <v-tooltip
          :text="theme.title"
          activator="parent"
          location="end"
        />
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup lang="ts">
import { themeIconList } from '@/utils/themeIconList';


// Props
const props = defineProps<{
  currentTheme: string | null;
}>();

// Events
const emit = defineEmits<{
  (e: 'changeTheme', slug: string): void;
}>();

// State
const themes = themeIconList.filter(t => t.active);

// Methods
const handleThemeClick = (slug: string) => {
  if (slug !== props.currentTheme) {
    emit('changeTheme', slug);
  }
};
</script>
