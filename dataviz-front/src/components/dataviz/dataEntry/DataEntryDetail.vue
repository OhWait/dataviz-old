<template>
  <div>
    <v-tabs
      v-if="hasMultipleDataEntries"
      v-model="currentDataEntry"
      fixed-tabs
      color="blue-darken-4"
      id="data-entry-tabs"
    >
      <v-tab
        v-for="dataEntry in dataEntries"
        :key="dataEntry.slug"
        :text="dataEntry.title"
        :value="dataEntry"
      />
    </v-tabs>

    <v-tabs-window
      v-model="currentDataEntry"
      class="py-7"
      id="data-entry-tabs-window"
    >
      <v-tabs-window-item
        v-for="dataEntry in dataEntries"
        :key="dataEntry.slug"
        :value="dataEntry"
      >
        <v-container>
          <v-row
            align="center"
            justify="center"
          >
            <v-col cols="2">
              <v-tabs
                v-model="currentMetaTab"
                direction="vertical"
                id="meta-tabs"
              >
                <v-tab
                  v-for="tab in metaTabs"
                  :key="tab.value"
                  :text="tab.text"
                  :value="tab.value"
                />
              </v-tabs>
            </v-col>

            <v-col cols="10">
              <v-tabs-window
                v-model="currentMetaTab"
                class="flex-fill"
                id="meta-tabs-window"
              >
                <v-tabs-window-item
                  v-for="tab in metaTabs"
                  :key="tab.value"
                  :text="tab.text"
                  :value="tab.value"
                >
                  <component
                    :is="getComponent(tab.value)"
                    v-bind="getPropsForTab(tab.value)"
                    @load-items="loadItems"
                  />
                </v-tabs-window-item>
              </v-tabs-window>
            </v-col>
          </v-row>
        </v-container>
      </v-tabs-window-item>
    </v-tabs-window>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useI18n } from 'vue-i18n';
import MetaDetail from '@/components/dataviz/metaColumn/MetaTable.vue';
import TablePreview from '@/components/dataviz/dataEntry/TablePreview.vue';
import { IDataEntry } from '@/@types/dataviz/dataEntry';

const props = defineProps<{
  dataEntries: IDataEntry[];
  items: any[];
  loading: boolean;
  error: Error | null;
}>();

// Emits
const emit = defineEmits<{
  (e: 'load-items', slug: string): void;
}>();

// Setup
const { t } = useI18n();
const currentDataEntry = ref(props.dataEntries[0]);
const currentMetaTab = ref('');
const componentMapping: Record<string, any> = {
  meta: MetaDetail,
  preview: TablePreview,
};

// Computed
const metaTabs = computed(() => [
  { text: t('dataset.tab.meta'), value: 'meta' },
  { text: t('dataset.tab.preview'), value: 'preview' },
]);
const hasMultipleDataEntries = computed(() => props.dataEntries.length > 1);

// Methods
const getComponent = (tab: string) => componentMapping[tab] ?? null;
const getPropsForTab = (tab: string) => {
  if (tab === 'meta') {
    return { metaColumns: currentDataEntry.value.columns };
  }
  return { ...props };
};
const loadItems = () => emit('load-items', currentDataEntry.value.slug);
</script>
