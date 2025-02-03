<template>
  <v-container v-if="isLoading">
    <SkeletonCard />
  </v-container>

  <div v-else-if="hasItem">
    <v-breadcrumbs :items="breadItems" />

    <div class="pb-15">
      <HeaderDetail :item="item" />
    </div>

    <div class="bg-light-blue-lighten-5 py-15" v-if="item.description">
      <DescriptionDetail :item="item" />
    </div>

    <div class="px-4" v-if="item.dataEntries?.length > 0">
      <DataEntryDetail :data-entries="item.dataEntries" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { useStore } from '@/store';
import { DatasetStore, DatasetRoutes, IDataset } from '@/@types/dataset';
import { computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import HeaderDetail from '@/features/dataset/detail/HeaderDetail.vue';
import DescriptionDetail from '@/features/dataset/detail/DescriptionDetail.vue';
import DataEntryDetail from '@/features/dataset/detail/DataEntryDetail.vue';
import SkeletonCard from '@/components/SkeletonCard.vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const store = useStore();
const route = useRoute();

const slug = route.params.slug as string;

onMounted(() => {
  store.dispatch(DatasetStore.FETCH_ITEM, slug);
});

const item = computed<IDataset>(() => store.getters[DatasetStore.GET_ITEM]);
const hasItem = computed<boolean>(() => store.getters[DatasetStore.HAS_ITEM]);
const isLoading = computed<boolean>(
  () => store.getters[DatasetStore.GET_ITEM_LOADING]
);
const breadItems = computed(() => [
  { title: t('dataset'), to: { name: DatasetRoutes.Collection } },
  { title: item.value.title, disabled: true },
]);
</script>

<style>
.description-content p {
  margin-bottom: 16px;
}
</style>
