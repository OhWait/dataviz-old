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
          {{ item.granularity }}
        </v-btn>
      </v-col>
    </v-row>

    <v-text-field
      v-model="search"
      label="Search"
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
        isHydraCollectionOfMunicipality(data)
      "
      :data="data.member"
      @select="selectMunicipality"
    />
  </v-container>
</template>

<script setup lang="ts">
import {
  IDepartment,
  IMunicipality,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { granularityEndpoints as granularities } from '@/utils/granularityHelper';
import { ref } from 'vue';
import MunicipalityList from './list/MunicipalityList.vue';

let searchTimeout: NodeJS.Timeout | null = null;

// Props
defineProps<{
  data: HydraCollection<IMunicipality | IDepartment> | null;
  currentGranularity: Granularity | null;
  isLoading: boolean;
}>();

// Emits
const emit = defineEmits<{
  (e: 'search', value: string): void;
  (e: 'changeGranularity', granularity: Granularity): void;
  (e: 'select', municipality: IMunicipality): void;
}>();

// Variables
const search = ref('');
const isTyping = ref(false);

// Methods
const selectGranularity = (granularity: Granularity) =>
  emit('changeGranularity', granularity);

const onSearch = () => {
  isTyping.value = true;

  if (searchTimeout) clearTimeout(searchTimeout);

  searchTimeout = setTimeout(() => {
    emit('search', search.value);
    isTyping.value = false;
  }, 1500);
};

const selectMunicipality = (municipality: IMunicipality) =>
  emit('select', municipality);

const isHydraCollectionOfMunicipality = (
  data: any
): data is HydraCollection<IMunicipality> => {
  return (
    typeof data?.member === 'object' &&
    data?.member[0] &&
    data?.member[0].codgeo
  );
};
</script>
