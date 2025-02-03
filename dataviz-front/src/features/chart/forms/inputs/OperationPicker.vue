<template>
  <v-select
    :model-value="modelValue"
    :items="valueOperationOptions"
    :label="$t('chart.form.operation')"
    item-title="text"
    item-value="value"
    :disabled="!dataType"
    required
    variant="underlined"
    @update:model-value="updateValue"
  />
</template>

<script setup lang="ts">
import { defineProps, defineEmits, computed } from 'vue';
import { operationList } from '@/@types/chart/utils/operationList';
import { DataType } from '@/@types/column';
import { Operation } from '@/@types/chart/model/payload';

// Props
const props = defineProps({
  modelValue: {
    type: String as () => Operation | null,
    default: null,
  },

  dataType: {
    type: String as () => DataType | undefined,
    required: false,
    default: undefined,
  },
});

// Emits
const emit = defineEmits(['update:modelValue']);

// Computed options based on the dataType
const valueOperationOptions = computed(() =>
  operationList
    .filter(o => o.available(props.dataType))
    .map(o => ({
      text: o.text,
      value: o.value,
    }))
);

const updateValue = (value: string) => {
  emit('update:modelValue', value);
};
</script>
