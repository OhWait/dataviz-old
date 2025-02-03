<template>
  <v-col v-for="i in nb" :key="i" :cols="cols">
    <v-skeleton-loader class="border" type="heading,text,paragraph" />
  </v-col>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface Props {
  nb?: number;
  cols?: number;
}

const props = defineProps<Props>();
const cols = computed(() => props.cols ?? 12);
const nb = computed(() => props.nb ?? 1);
</script>
