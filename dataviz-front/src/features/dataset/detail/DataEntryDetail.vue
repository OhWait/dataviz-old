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
          <v-row align="center" justify="center">
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

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import MetaDetail from '@/features/metaColumn/MetaTable.vue';
import PreviewDetail from '@/features/dataEntry/TablePreview.vue';
import { IDataEntry } from '@/@types/dataEntry';
import { IMetaColumn } from '@/@types/column';

type MetaDetail = {
  metaColumns: IMetaColumn[];
};

type PreviewDetail = {
  slug: string;
};

type TabComponent = typeof MetaDetail | typeof PreviewDetail;

export default defineComponent({
  props: {
    dataEntries: {
      type: Array as PropType<IDataEntry[]>,
      required: true,
    },
  },

  data() {
    return {
      currentDataEntry: this.dataEntries[0],
      currentMetaTab: '',
      metaTabs: [
        {
          text: this.$t('dataset.tab.meta'),
          value: 'meta',
        },
        {
          text: this.$t('dataset.tab.preview'),
          value: 'preview',
        },
      ],
    };
  },

  computed: {
    hasMultipleDataEntries(): boolean {
      return this.dataEntries.length > 1;
    },
  },

  methods: {
    getComponent(tab: string): TabComponent | null {
      const componentMapping: Record<string, TabComponent> = {
        meta: MetaDetail,
        preview: PreviewDetail,
      };

      return componentMapping[tab] ?? null;
    },

    getPropsForTab(tab: string) {
      if (tab === 'meta') {
        return { metaColumns: this.currentDataEntry.columns };
      }

      return { slug: this.currentDataEntry.slug };
    },
  },
});
</script>
