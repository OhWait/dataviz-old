<template>
  <v-container>
    <v-form
      ref="formRef"
      validate-on="submit"
      @submit.prevent="submitPolar"
    >
      <!-- Select for Values -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="form.values.dataEntry"
        :dataset="dataset"
        :rules="[required]"
      />

      <ColumnPicker
        v-model="form.values.column"
        :label="$t('chart.form.polar.values')"
        :data-entry="valuesDataEntry"
        :rules="[required]"
      />

      <OperationPicker
        v-model="form.values.operation"
        :data-type="dataType"
        :rules="[required]"
      />

      <br />

      <!-- Select for Series -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="form.serie.dataEntry"
        :dataset="dataset"
        :rules="[required]"
      />

      <ColumnPicker
        v-model="form.serie.column"
        :label="$t('chart.form.polar.series')"
        :data-entry="serieDataEntry"
        :rules="[required]"
      />

      <v-btn
        block
        type="submit"
      >
        Envoyer
      </v-btn>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { IPolarForm } from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import ColumnPicker from './input/ColumnPicker.vue';
import OperationPicker from './input/OperationPicker.vue';
import DataEntryPicker from './input/DataEntryPicker.vue';
import { computed, watch, reactive, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { VForm } from 'vuetify/lib/components/index.mjs';

// Props
const props = defineProps<{
  payload: IPolarForm;
  dataset: IDataset;
}>();

// Emits
const emit = defineEmits<{
  (e: 'submit', payload: IPolarForm): void;
}>();

// Setup
const { t } = useI18n();
const required = (value: any) => !!value || t('form.required');
const formRef = ref<VForm | null>(null);
const form = reactive({ ...props.payload });

// Computed
const dataEntries = computed(() => props.dataset.dataEntries);
const hasMultipleDataEntries = computed(() => dataEntries.value.length > 1);
const valuesDataEntry = computed(() => getDataEntry(form.values.dataEntry));
const serieDataEntry = computed(() => getDataEntry(form.serie.dataEntry));
const dataType = computed(
  () =>
    valuesDataEntry.value?.columns.find(
      c => c.columnName === form.values.column
    )?.dataType
);

// Methods
const getDataEntry = (slug: string | null) =>
  dataEntries.value.find(d => d.slug === slug) ?? dataEntries.value[0];

const submitPolar = async () => {
  if (!formRef.value) return;

  const { valid } = await formRef.value.validate();

  if (valid) {
    emit('submit', form);
  }
};

// Reset column and operation when dataEntry changes
watch(
  () => form.values.dataEntry,
  () => {
    form.values.column = null;
    form.values.operation = null;
  }
);

// Reset operation when column changes
watch(
  () => form.values.column,
  () => (form.values.operation = null)
);
</script>
