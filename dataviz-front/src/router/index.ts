import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import Routes from '@/@types/routes';
import datasetRoutes from '@/router/datasetRoutes.js';
import chartRoutes from '@/router/chartRoutes.js';
import AdministrativeDivisionView from '@/views/AdministrativeDivisionView.vue';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: '/dataset',
    name: Routes.Home,
  },
  ...datasetRoutes,
  ...chartRoutes,
  {
    path: '/map',
    name: 'map',
    component: AdministrativeDivisionView,
  },
];

export const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});
