import routes from '@/@types/routes';
import DatasetCollectionView from '@/views/dataset/DatasetCollectionView.vue';
import DatasetDetailView from '@/views/dataset/DatasetDetailView.vue';
import { RouteRecordRaw } from 'vue-router';

const datasetRoutes: RouteRecordRaw[] = [
  {
    path: '/dataset',
    name: routes.Dataset.Collection,
    component: DatasetCollectionView,
  },
  {
    path: '/dataset/:slug',
    name: routes.Dataset.Item,
    component: DatasetDetailView,
  },
];

export default datasetRoutes;
