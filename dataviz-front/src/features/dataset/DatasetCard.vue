<template>
  <v-card color="blue-grey-lighten-5" :to="to">
    <v-card-title>{{ item.title }}</v-card-title>
    <v-card-subtitle>{{ item.shortTitle }}</v-card-subtitle>

    <v-card-text>
      <p>Perimeter: {{ item.perimeter }}</p>
      <p>Granularity: {{ item.granularity }}</p>
      <p>Update Frequency: {{ item.updateFrequency }}</p>
      <p>Language: {{ item.language }}</p>
      <p>Data Created At: {{ item.dataCreatedAt }}</p>
      <p>Data Updated At: {{ item.dataUpdatedAt }}</p>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { DatasetRoutes, IDatasetCollection } from '@/@types/dataset';

interface Props {
  item: IDatasetCollection;
  link?: boolean;
}

const props = defineProps<Props>();
const to = computed(() =>
  props.link
    ? { name: DatasetRoutes.Item, params: { slug: props.item?.slug } }
    : undefined
);
</script>
