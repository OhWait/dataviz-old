<template>
  <v-container fluid>
    <v-row>
      <v-col cols="3">
        <AdministrativeDivision
          :currentGranularity="currentGranularity"
          :data="data"
          @change-granularity="handleGranularityChange"
          @search="handleSearch"
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

const store = useAdministrativeDivisionStore();

// Computed
const currentGranularity = computed(() => store.getCurrentGranularity);
const data = computed(() => store.getCollection);

// Methods
const handleGranularityChange = (granularity: Granularity) =>
  store.fetchAdministrativeDivision(granularity);

const handleSearch = (search: string) => {
  console.log(search);
};

// LifeCycle
onMounted(() => store.fetchAdministrativeDivision(currentGranularity.value));
</script>
