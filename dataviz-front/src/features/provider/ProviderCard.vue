<template>
  <v-card>
    <div class="d-flex flex-no-wrap justify-space-between">
      <div v-if="imgSrc" class="align-self-center">
        <v-img :src="imgSrc" class="ma-3" width="125" />
      </div>

      <div class="text-content">
        <v-card-title class="text-h5">
          {{ item.name }}
        </v-card-title>

        <v-card-subtitle v-if="item.acronym">
          {{ item.acronym }}
        </v-card-subtitle>

        <v-card-text class="text-justify">{{ item.description }}</v-card-text>
      </div>
    </div>
  </v-card>
</template>

<script setup lang="ts">
import { IProvider } from '@/@types/provider';
import { getImageUrl } from '@/api/dataviz/datavizClient';

interface Props {
  item: IProvider;
}

const props = defineProps<Props>();

const imgSrc = props.item.image ? getImageUrl(props.item.image) : null;
</script>

<style scoped>
.text-content {
  flex: 1;
  min-width: 0;
}
</style>
