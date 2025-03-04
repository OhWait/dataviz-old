<template>
  <v-container>
    <v-row v-if="isLoading">
      <SkeletonCard :nb="12" :cols="4" />
    </v-row>

    <v-row v-else>
      <v-col v-for="item in items" :key="item['@id']" cols="12" sm="4">
        <DatasetCard :item="item" :link="true" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { useDatasetStore } from '@/store/datasetStore';
import SkeletonCard from '@/components/SkeletonCard.vue';
import DatasetCard from '@/components/dataviz/dataset/DatasetCard.vue';

const datasetStore = useDatasetStore();

onMounted(() => datasetStore.fetchCollection());

const items = computed(() => datasetStore.getCollectionMembers);
const isLoading = computed(() => datasetStore.getCollectionLoading);
</script>
