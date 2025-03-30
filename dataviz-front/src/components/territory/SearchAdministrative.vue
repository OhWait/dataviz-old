<template>
  <v-container>
    <v-row class="mb-4">
      <v-col
        cols="auto"
        v-for="item in granularities"
        :key="item.granularity"
      >
        <v-btn
          :active="item.granularity === currentGranularity"
          @click="selectGranularity(item.granularity)"
        >
          {{ item.title }}
        </v-btn>
      </v-col>
    </v-row>

    <v-text-field
      v-model="search"
      :label="$t('search')"
      @input="onSearch"
      :loading="isTyping"
    />

    <v-skeleton-loader
      v-if="isLoading"
      type="list-item-two-line"
      :loading="isLoading"
      :item-count="10"
    />

    <MunicipalityList
      v-else-if="
        currentGranularity === Granularity.Municipalitie &&
        isMunicipalityCollection(data)
      "
      :data="data.member"
      @select="e => $emit('selectMunicipality', e)"
    />

    <PiicList
      v-else-if="
        currentGranularity === Granularity.Piic && isPiicCollection(data)
      "
      :data="data.member"
      @select="e => $emit('selectPiic', e)"
    />

    <DepartmentList
      v-else-if="
        currentGranularity === Granularity.Department &&
        isDepartmentCollection(data)
      "
      :data="data.member"
      @select="e => $emit('selectDepartment', e)"
    />
  </v-container>
</template>

<script setup lang="ts">
import {
  IDepartment,
  IDepartmentCollection,
  IMunicipalityCollection,
  IPiic,
  IPiicCollection,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { granularityEndpoints as granularities } from '@/utils/granularityHelper';
import { ref } from 'vue';
import MunicipalityList from './list/MunicipalityList.vue';
import PiicList from './list/PiicList.vue';
import DepartmentList from './list/DepartmentList.vue';

let searchTimeout: NodeJS.Timeout | null = null;

// Props
defineProps<{
  data: HydraCollection<
    IMunicipalityCollection | IPiicCollection | IDepartmentCollection
  > | null;
  currentGranularity: Granularity | null;
  isLoading: boolean;
}>();

// Emits
const emit = defineEmits<{
  (e: 'search', value: string): void;
  (e: 'changeGranularity', granularity: Granularity): void;
  (e: 'selectMunicipality', municipality: IMunicipalityCollection): void;
  (e: 'selectPiic', piic: IPiic): void;
  (e: 'selectDepartment', department: IDepartment): void;
}>();

// Variables
const search = ref('');
const isTyping = ref(false);

// Methods
const selectGranularity = (granularity: Granularity) => {
  search.value = '';
  emit('changeGranularity', granularity);
};

const onSearch = () => {
  isTyping.value = true;

  if (searchTimeout) clearTimeout(searchTimeout);

  searchTimeout = setTimeout(() => {
    emit('search', search.value);
    isTyping.value = false;
  }, 1500);
};

const isMunicipalityCollection = (
  data: any
): data is HydraCollection<IMunicipalityCollection> => {
  return (
    typeof data?.member === 'object' &&
    data?.member[0] &&
    data?.member[0].codgeo
  );
};

const isPiicCollection = (
  data: any
): data is HydraCollection<IPiicCollection> => {
  return (
    typeof data?.member === 'object' && data?.member[0] && data?.member[0].codeepci
  );
};

const isDepartmentCollection = (
  data: any
): data is HydraCollection<IDepartmentCollection> => {
  return (
    typeof data?.member === 'object' && data?.member[0] && data?.member[0].codedep
  );
};
</script>
