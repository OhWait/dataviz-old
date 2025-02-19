<template>
  <v-select
    :model-value="modelValue"
    :items="items"
    :label="label"
    item-title="text"
    item-value="value"
    variant="underlined"
    :disabled="disabled"
    :rules="rules ?? []"
    @update:model-value="emit('update:modelValue', $event)"
  >
    <template #item="{ item, props }">
      <v-list-item
        v-bind="props"
        :prepend-icon="item.raw.icon"
        max-width="400"
        class="wrap-text"
      />
    </template>
  </v-select>
</template>

<script setup lang="ts">
import { IDataEntry } from '@/@types/dataviz/dataEntry';
import { dataTypeIconMapping } from '@/utils/dataTypeIconMapping';
import { computed } from 'vue';

// Props
const props = defineProps<{
  modelValue: string | null;
  dataEntry?: IDataEntry;
  label: string;
  rules?: ((value: any) => boolean | string)[];
}>();

// Emit
const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>();

// Computed
const disabled = computed(() => props.dataEntry === undefined);
const items = computed(() =>
  props.dataEntry?.columns.map(col => ({
    text: col.label,
    value: col.columnName,
    icon: dataTypeIconMapping[col.dataType],
  }))
);
</script>

<style>
.wrap-text .v-list-item-title {
  white-space: normal;
  word-wrap: break-word;
}
</style>
