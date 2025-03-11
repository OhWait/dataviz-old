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
    />

    <v-list v-if="data?.member">
      <v-list-item
        v-for="item in data.member"
        :key="item.code"
        @click="selectedItems.push(item)"
      >
        <v-list-item-title>{{ item.label }}</v-list-item-title>
      </v-list-item>
    </v-list>

    <v-chip
      v-for="item in selectedItems"
      :key="item.code"
      close
      @click:close="selectedItems.splice(selectedItems.indexOf(item), 1)"
    >
      {{ item.label }}
    </v-chip>
  </v-container>
</template>

<script setup lang="ts">
import { Granularity } from '@/@types/dataviz/dataset';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { IAdministrativeDivision } from '@/store/administrativeDivisionStore';
import { granularityEndpoints as granularities } from '@/utils/granularityHelper';
import { ref } from 'vue';

// Props
const props = defineProps<{
  data: HydraCollection<IAdministrativeDivision> | null;
  currentGranularity: Granularity | null;
}>();

// Emits
const emit = defineEmits<{
  (e: 'search', value: string): void;
  (e: 'changeGranularity', granularity: Granularity): void;
}>();

// Variables
const search = ref('');
const selectedItems = ref<IAdministrativeDivision[]>([]);

// Methods
const onSearch = () => emit('search', search.value);

const selectGranularity = (granularity: Granularity) => {
  emit('changeGranularity', granularity);
};
</script>
