<template>
  <v-container v-if="isLoading">
    <SkeletonCard />
  </v-container>

  <div v-else-if="item">
    <v-breadcrumbs :items="breadItems" />

    <div class="pb-15">
      <HeaderDetail :item="item" />
    </div>

    <div class="bg-light-blue-lighten-5 py-15" v-if="item.description">
      <DescriptionDetail :item="item" />
    </div>

    <div class="px-4" v-if="item.dataEntries.length > 0">
      <DataEntryDetail :data-entries="item.dataEntries" />
    </div>
  </div>

  <div v-else>
    An error occurred
  </div>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { useDatasetStore } from '@/store/datasetStore';
import { useRoute } from 'vue-router';
import HeaderDetail from '@/features/dataset/detail/HeaderDetail.vue';
import DescriptionDetail from '@/features/dataset/detail/DescriptionDetail.vue';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { useI18n } from 'vue-i18n';
import { DatasetRoutes } from '@/@types/dataviz/dataset';

const { t } = useI18n();
const datasetStore = useDatasetStore();
const route = useRoute();

const slug = route.params.slug as string;

onMounted(() => datasetStore.fetchItem(slug));

const item = computed(() => datasetStore.getItem);
const isLoading = computed(() => datasetStore.getItemLoading);
const breadItems = computed(() => [
  { title: t('dataset'), to: { name: DatasetRoutes.Collection } },
  { title: item.value?.title || '', disabled: true },
]);
</script>

<style>
.description-content p {
  margin-bottom: 16px;
}
</style>
