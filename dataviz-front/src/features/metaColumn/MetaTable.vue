<template>
  <v-data-table
    fixed-header
    :headers="headers"
    height="700"
    :items="metaColumns"
    :items-per-page="-1"
    item-value="columnName"
    show-expand
    hide-default-footer
  >
    <template #item="{ item, internalItem, toggleExpand, isExpanded }">
      <tr>
        <td class="text-center">
          <v-btn
            v-if="item.values.length > 0"
            icon
            @click="toggleExpand(internalItem)"
            size="small"
            variant="text"
          >
            <v-icon>
              {{
                isExpanded(internalItem)
                  ? 'mdi-chevron-down'
                  : 'mdi-chevron-right'
              }}
            </v-icon>
          </v-btn>
        </td>

        <td v-text="item.columnName" />

        <td class="text-center">
          <v-tooltip activator="parent">{{ item.dataType }}</v-tooltip>
          <v-icon :icon="getIconDataType(item.dataType)" size="x-large" />
        </td>

        <td class="text-center">
          <v-icon :icon="getIconNullable(item.isNullable)" size="x-large" />
        </td>

        <td v-text="item.characterMaximumLength" class="text-center" />

        <td v-text="item.label" />
      </tr>
    </template>

    <template #expanded-row="{ item }">
      <tr>
        <td :colspan="headers.length">
          <v-card class="ma-3 mx-auto" width="500">
            <v-data-table
              density="compact"
              fixed-header
              :height="fixedHeight(item.values)"
              :headers="valueHeaders"
              :items="item.values"
              :items-per-page="-1"
              hide-default-footer
            >
              <template #headers="{ columns }">
                <tr>
                  <th
                    v-for="column in columns"
                    :key="column.key!"
                    class="font-weight-bold"
                  >
                    {{ column.title }}
                  </th>
                </tr>
              </template>
            </v-data-table>
          </v-card>
        </td>
      </tr>
    </template>
  </v-data-table>
</template>

<script setup lang="ts">
import { IMetaColumn } from '@/@types/dataviz/column';
import { IValues } from '@/@types/values';
import { dataTypeIconMapping } from '@/@types/dataviz/column/dataType';
import { useI18n } from 'vue-i18n';
import { DataType } from '@/@types/dataviz/column/model';

const { t } = useI18n();

defineProps<{ metaColumns: IMetaColumn[] }>();

// State
const headers = [
  { title: '', key: 'data-table-expand' },
  { title: t('metacolumn.column_name'), key: 'columnName' },
  { title: t('metacolumn.data_type'), key: 'dataType' },
  { title: t('metacolumn.required'), key: 'isNullable' },
  {
    title: t('metacolumn.character_maximum_length'),
    key: 'characterMaximumLength',
  },
  { title: t('metacolumn.label'), key: 'label' },
];

const valueHeaders = [
  { title: 'Value', key: 'value' },
  { title: 'Label', key: 'label' },
];

// Methods
const getIconNullable = (isNullable: boolean) =>
  isNullable ? 'mdi-toggle-switch-off-outline' : 'mdi-toggle-switch';

const getIconDataType = (dataType: DataType) => {
  return dataTypeIconMapping[dataType] || 'mdi-help-circle';
};

const fixedHeight = (values: IValues[] | undefined) =>
  values && values.length > 12 ? 500 : -1;
</script>
