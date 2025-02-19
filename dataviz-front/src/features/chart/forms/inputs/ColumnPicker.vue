<template>
  <v-select
    :model-value="modelValue"
    :items="options"
    :label="label"
    item-title="text"
    item-value="value"
    required
    variant="underlined"
    @update:model-value="updateValue"
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
import { dataTypeIconMapping } from '@/@types/dataviz/column/dataType';
import { IDataEntry } from '@/@types/dataviz/dataEntry';
import { defineProps, defineEmits, computed } from 'vue';

// Define props
const Props = defineProps({
  modelValue: {
    type: String as () => string | null,
    default: null,
  },

  dataEntry: {
    type: Object as () => IDataEntry,
    required: true,
  },

  label: {
    type: String,
    required: true,
  },
});

const options = computed(() =>
  Props.dataEntry.columns.map(col => ({
    text: col.label,
    value: col.columnName,
    icon: dataTypeIconMapping[col.dataType],
  }))
);

// Define emits
const emit = defineEmits(['update:modelValue']);

// Method to update the value
const updateValue = (value: string) => {
  emit('update:modelValue', value);
};
</script>

<style>
.wrap-text .v-list-item-title {
  white-space: normal;
  word-wrap: break-word;
}
</style>
