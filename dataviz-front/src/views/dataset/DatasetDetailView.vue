<template>
  <v-container v-if="isLoading">
    <SkeletonCard />
  </v-container>

  <div v-else-if="item">
    <v-breadcrumbs :items="breadItems" />

    <div class="pb-15">
      <HeaderDetail :item="item" />
    </div>

    <div
      v-if="item.description"
      class="bg-light-blue-lighten-5 py-15"
    >
      <DescriptionDetail :item="item" />
    </div>

    <div
      v-if="item.dataEntries.length > 0"
      class="px-4"
    >
      <DataEntryDetail
        :data-entries="item.dataEntries"
        :items="tableMembers"
        :loading="tableLoading"
        :error="tableError"
        @load-items="loadItems"
      />
    </div>
  </div>

  <div v-else>An error occurred</div>
</template>

<script setup lang="ts">
import { DatasetRoutes } from '@/@types/dataviz/dataset';
import { useDatasetStore } from '@/store/datasetStore';
import { useDataEntryStore } from '@/store/dataEntryStore';
import HeaderDetail from '@/components/dataviz/dataset/HeaderDetail.vue';
import DescriptionDetail from '@/components/dataviz/dataset/DescriptionDetail.vue';
import DataEntryDetail from '@/components/dataviz/dataEntry/DataEntryDetail.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { useI18n } from 'vue-i18n';
import { useRoute } from 'vue-router';
import { onMounted, computed } from 'vue';

// Setup
const { t } = useI18n();
const datasetStore = useDatasetStore();
const dataEntryStore = useDataEntryStore();
const route = useRoute();
const slug = route.params.slug as string;

// Computed
const item = computed(() => datasetStore.getItem);
const isLoading = computed(() => datasetStore.getItemLoading);
const breadItems = computed(() => [
  { title: t('dataset'), to: { name: DatasetRoutes.Collection } },
  { title: item.value?.title || '', disabled: true },
]);

const tableMembers = computed(() => dataEntryStore.getTableMembers);
const tableLoading = computed(() => dataEntryStore.getTableLoading);
const tableError = computed(() => dataEntryStore.getTableError);

// Methods
const loadItems = async (slug: string) =>
  await dataEntryStore.fetchTable({ slug, page: 1, itemsPerPage: 100 });

onMounted(() => datasetStore.fetchItem(slug));
</script>

<style>
.description-content p {
  margin-bottom: 16px;
}
</style>
