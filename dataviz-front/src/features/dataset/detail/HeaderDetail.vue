<template>
  <v-container>
    <v-row>
      <v-col lg="9" md="12">
        <ProviderCard :item="item.provider" />
      </v-col>

      <v-col lg="3">
        <v-list lines="one" class="d-lg-inline d-sm-none d-xs-none">
          <v-list-item title="My Application" subtitle="Vuetify" />
          <v-divider />
          <v-list-item link title="List Item 1" />
          <v-list-item link title="List Item 2" />
          <v-list-item link title="List Item 3" />
        </v-list>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { IDataset } from '@/@types/dataviz/dataset';
import ProviderCard from '@/features/provider/ProviderCard.vue';

interface Props {
  item: IDataset;
}

defineProps<Props>();
</script>
