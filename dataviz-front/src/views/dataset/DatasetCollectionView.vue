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
import SkeletonCard from '@/components/SkeletonCard.vue';
import DatasetCard from '@/features/dataset/DatasetCard.vue';
import { useStore } from '@/store';
import { DatasetStore } from '@/@types/dataset';
import { computed, onMounted } from 'vue';

const store = useStore();

onMounted(() => store.dispatch(DatasetStore.FETCH_COLLECTION));

const items = computed(
  () => store.getters[DatasetStore.GET_COLLECTION_MEMBERS]
);

const isLoading = computed(
  () => store.getters[DatasetStore.GET_COLLECTION_LOADING]
);
</script>
