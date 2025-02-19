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
import { useDataEntryStore } from '@/store/dataEntryStore';
import { useI18n } from 'vue-i18n';

// Props
const props = defineProps<{ slug: string }>();

// State
const page = ref(1);
const itemsPerPage = ref(200);

const store = useDataEntryStore();
const { t } = useI18n();

// Getters
const items = computed(() => store.getTableMembers);
const loading = computed(() => store.getTableLoading);
const error = computed(() => store.getTableError);

const headers = computed(() => {
  if (items.value.length > 0) {
    return Object.keys(items.value[0]).map(key => ({ title: key, key }));
  }
  return [];
});

// Actions
const loadItems = async () => {
  await store.fetchTable({
    slug: props.slug,
    page: page.value,
    itemsPerPage: itemsPerPage.value,
  });
};

// Lifecycle Hook
onMounted(() => loadItems());
</script>
