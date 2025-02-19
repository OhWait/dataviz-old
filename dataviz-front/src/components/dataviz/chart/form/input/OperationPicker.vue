<template>
  <v-select
    :model-value="modelValue"
    :items="valueOperationOptions"
    :label="$t('chart.form.operation')"
    item-title="text"
    item-value="value"
    :disabled="!dataType"
    variant="underlined"
    :rules="rules ?? []"
    @update:model-value="emit('update:modelValue', $event)"
  />
</template>

<script setup lang="ts">
import { DataType } from '@/@types/dataviz/column';
import { Operation } from '@/@types/dataviz/chart';
import { operationList } from '@/utils/operationList';
import { computed } from 'vue';

// Props
const props = defineProps<{
  modelValue: Operation | null;
  dataType?: DataType;
  rules?: ((value: any) => boolean | string)[];

}>();

// Emit
const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>();

// Computed
const valueOperationOptions = computed(() =>
  operationList
    .filter(o => o.available(props.dataType))
    .map(o => ({
      text: o.text,
      value: o.value,
    }))
);
</script>
