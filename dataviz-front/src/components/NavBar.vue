<template>
  <v-app-bar color="primary" density="compact">
    <v-app-bar-title>
      <v-btn :to="{ name: Routes.Home }">{{ $t('navbar.title') }}</v-btn>
    </v-app-bar-title>

    <v-btn :to="{ name: Routes.Dataset.Collection }">
      {{ $t('navbar.item.dataset') }}
    </v-btn>

    <v-btn :to="{ name: Routes.Chart.Index }">
      {{ $t('navbar.item.chart') }}
    </v-btn>

    <v-btn :to="{ name: Routes.Chart.Bis }">
      {{ $t('navbar.item.chart') }}
    </v-btn>

    <v-spacer />
  </v-app-bar>
</template>

<script setup lang="ts">
import Routes from '@/@types/routes';
</script>
