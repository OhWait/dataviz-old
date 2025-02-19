<template>
  <v-container class="text-justify">
    <div class="text-h4 mb-3" v-text="item.title" />

    <div
      class="text-subtitle-1 font-weight-bold mb-3"
      v-text="$t('dataset.description')"
    />

    <div v-html="item.description" class="description-content" />
  </v-container>
</template>

<script setup lang="ts">
import { IDataset } from '@/@types/dataviz/dataset';

defineProps<{ item: IDataset }>();
</script>
