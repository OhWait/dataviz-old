<template>
  <v-container fluid>
    <v-row>
      <v-col cols="3">
        <AdministrativeDivision
          :currentGranularity="granularity"
          :data="data"
          :isLoading="isLoading"
          @change-granularity="handleGranularityChange"
          @search="handleSearch"
          @select="handleSelect"
        />
      </v-col>

      <v-col cols="9">
        <Map />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import { useAdministrativeDivisionStore } from '@/store/administrativeDivisionStore';
import AdministrativeDivision from '@/components/territory/AdministrativeDivision.vue';
import Map from '@/components/territory/Map.vue';
import { computed, onMounted, ref } from 'vue';
import { IMunicipality } from '@/@types/dataviz/administrativeDivision';

const store = useAdministrativeDivisionStore();
const itemsPerPage = 10;

// Computed
const granularity = ref<Granularity>(Granularity.Municipalitie);
const isLoading = computed(() => store.getLoadingMunicipality);
const data = computed(() => {
  if (granularity.value === Granularity.Municipalitie) {
    return store.getMunicipalities;
  }

  return null;
})

// Methods
const handleGranularityChange = (granularity: Granularity) =>
  store.fetchAdministrativeDivision({
    granularity,
    itemsPerPage,
  });

const handleSearch = (label: string) =>
  store.fetchAdministrativeDivision({
    label,
    granularity: granularity.value,
    itemsPerPage,
  });

const handleSelect = (municipality: IMunicipality) => {
  console.log(municipality);
};

// LifeCycle
onMounted(() =>
  store.fetchAdministrativeDivision({
    granularity: granularity.value,
    itemsPerPage,
  })
);
</script>
