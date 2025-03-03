<template>
  <v-container>
    <v-form
      ref="formRef"
      validate-on="submit"
      @submit.prevent="submitCartesian"
    >
      <!-- Select for Distribution -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="form.distribution.dataEntry"
        :dataset="dataset"
        :rules="[required]"
      />

      <ColumnPicker
        v-model="form.distribution.column"
        :label="
          reverseAxe
            ? $t('chart.form.cartesian.operation')
            : $t('chart.form.cartesian.distribution')
        "
        :data-entry="operationDataEntry"
        :rules="[required]"
      />

      <br />

      <!-- Select for Operation -->
      <DataEntryPicker
        v-if="hasMultipleDataEntries"
        v-model="form.operation.dataEntry"
        :dataset="dataset"
        :rules="[required]"
      />

      <ColumnPicker
        v-model="form.operation.column"
        :label="
          reverseAxe
            ? $t('chart.form.cartesian.distribution')
            : $t('chart.form.cartesian.operation')
        "
        :data-entry="serieDataEntry"
        :rules="[required]"
      />

      <OperationPicker
        v-model="form.operation.operation"
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
import { ICartesianForm, View } from '@/@types/dataviz/chart';
import { IDataset } from '@/@types/dataviz/dataset';
import ColumnPicker from './input/ColumnPicker.vue';
import OperationPicker from './input/OperationPicker.vue';
import DataEntryPicker from './input/DataEntryPicker.vue';
import { computed, watch, reactive, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import { VForm } from 'vuetify/lib/components/index.mjs';
import { reversedCartesianAxe } from '@/utils/viewList';

// Props
const props = defineProps<{
  currentView: View;
  payload: ICartesianForm;
  dataset: IDataset;
}>();

// Emits
const emit = defineEmits<{
  (e: 'submit', payload: ICartesianForm): void;
}>();

// Setup
const { t } = useI18n();
const required = (value: any) => !!value || t('form.required');
const formRef = ref<VForm | null>(null);
const form = reactive({ ...props.payload });

// Computed
const reverseAxe = computed(() =>
  reversedCartesianAxe.includes(props.currentView)
);
const dataEntries = computed(() => props.dataset.dataEntries);
const hasMultipleDataEntries = computed(() => dataEntries.value.length > 1);
const operationDataEntry = computed(() =>
  getDataEntry(form.operation.dataEntry)
);
const serieDataEntry = computed(() => getDataEntry(form.serie.dataEntry));
const dataType = computed(
  () =>
    operationDataEntry.value?.columns.find(
      c => c.columnName === form.operation.column
    )?.dataType
);

// Methods
const getDataEntry = (slug: string | null) =>
  dataEntries.value.find(d => d.slug === slug) ?? dataEntries.value[0];

const submitCartesian = async () => {
  if (!formRef.value) return;

  const { valid } = await formRef.value.validate();

  if (valid) {
    emit('submit', form);
  }
};

// Reset distribution
watch(
  () => form.distribution.dataEntry,
  () => {
    form.distribution.column = null;
    form.distribution.dateOperation = null;
  }
);

// Reset operation
watch(
  () => form.operation.dataEntry,
  () => {
    form.operation.column = null;
    form.operation.operation = null;
  }
);
watch(
  () => form.operation.column,
  () => (form.operation.operation = null)
);

// Reset series
watch(
  () => form.serie.dataEntry,
  () => (form.serie.column = null)
);
</script>
