<template>
  <v-container fluid>
    <v-row>
      <v-col cols="4">
        <SearchAdministrative
          :currentGranularity="granularity"
          :data="data"
          :isLoading="isLoading"
          @change-granularity="handleGranularityChange"
          @search="handleSearch"
          @select-municipality="handleMunicipalitySelect"
          @select-piic="handlePiicSelect"
          @select-department="handleDepartmentSelect"
        />

        <SelectedAdministrativeDivision
          :selected-territories="selected"
          @remove-territory="handleRemoveMunicipality"
        />
      </v-col>

      <v-col cols="8">
        <Map
          ref="mapComponent"
          :selected-municipalities="selected"
          @select-municipality="handleMunicipalitySelect"
          @select-piic="handlePiicSelect"
          @select-department="handleDepartmentSelect"
        />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import {
  IDepartment,
  IMunicipality,
  IPiic,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import { useAdministrativeDivisionStore } from '@/store/administrativeDivisionStore';
import SearchAdministrative from '@/components/territory/SearchAdministrative.vue';
import Map from '@/components/territory/Map.vue';
import { computed, onMounted, ref } from 'vue';
import SelectedAdministrativeDivision from './SelectedAdministrativeDivision.vue';

const store = useAdministrativeDivisionStore();
const itemsPerPage = 10;
const selected = ref<IMunicipality[]>([]);
const granularity = ref<Granularity>(Granularity.Municipalitie);
const mapComponent = ref<InstanceType<typeof Map> | null>(null);

// Computed
const isLoading = computed(
  () =>
    store.getLoadingMunicipality ||
    store.getLoadingPiic ||
    store.getLoadingDepartment
);
const data = computed(() => {
  if (granularity.value === Granularity.Municipalitie) {
    return store.getMunicipalities;
  }

  if (granularity.value === Granularity.Piic) {
    return store.getPiics;
  }

  if (granularity.value === Granularity.Department) {
    return store.getDepartments;
  }

  return null;
});

// Methods
const handleGranularityChange = (newGranularity: Granularity) => {
  granularity.value = newGranularity;
  store.fetchAdministrativeDivision({
    granularity: newGranularity,
    itemsPerPage,
  });
};

const handleSearch = (label: string) =>
  store.fetchAdministrativeDivision({
    label,
    granularity: granularity.value,
    itemsPerPage,
  });

const handleMunicipalitySelect = (municipality: IMunicipality) => {
  const index = selected.value.findIndex(m => m.codgeo === municipality.codgeo);

  if (index !== -1) {
    selected.value.splice(index, 1);
    mapComponent.value?.removeMunicipality(municipality);
  } else {
    selected.value = [...selected.value, municipality];
    mapComponent.value?.activeMunicipality(municipality);
  }
};

const handleRemoveMunicipality = (municipality: IMunicipality) => {
  const index = selected.value.findIndex(m => m.codgeo === municipality.codgeo);

  if (index !== -1) {
    selected.value.splice(index, 1);
    mapComponent.value?.removeMunicipality(municipality);
  }
};

const handlePiicSelect = (piic: IPiic) => {
  console.log(piic);
};

const handleDepartmentSelect = (department: IDepartment) =>
  console.log(department);

// LifeCycle
onMounted(() =>
  store.fetchAdministrativeDivision({
    granularity: granularity.value,
    itemsPerPage,
  })
);
</script>
