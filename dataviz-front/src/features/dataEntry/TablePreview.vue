<template>
  <div>
    <v-alert v-if="error" border="start" type="error">
      {{ $t('dataentry.preview.error') }}
    </v-alert>

    <v-data-table-server
      v-else
      :headers="headers"
      :items="items"
      :items-length="500"
      :loading="loading"
      :height="500"
      fixed-header
    >
      <template #bottom></template>
    </v-data-table-server>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { DataEntryStore } from '@/@types/dataEntry';
import { useStore } from '@/store';

// Props
const props = defineProps<{ slug: string }>();

// State
const page = ref(1);
const itemsPerPage = ref(200);

const store = useStore();

// Getters
const items = computed(() => store.getters[DataEntryStore.GET_TABLE_MEMBERS]);
const loading = computed(() => store.getters[DataEntryStore.GET_TABLE_LOADING]);
const error = computed(() => store.getters[DataEntryStore.GET_TABLE_ERROR]);

const headers = computed(() => {
  if (items.value.length > 0) {
    return Object.keys(items.value.at(0)).map(key => ({ title: key, key }));
  }

  return [];
});

// Actions
const loadItems = async () =>
  await store.dispatch(DataEntryStore.FETCH_TABLE, {
    slug: props.slug,
    page: page.value,
    itemsPerPage: itemsPerPage.value,
  });

// Lifecycle Hook
onMounted(() => loadItems());
</script>
