import { RouteRecordRaw } from 'vue-router';
import routes from '@/@types/routes';
import SingleChartView from '@/views/chart/SingleChartView.vue';

const chartRoutes: RouteRecordRaw[] = [
  {
    path: '/chart',
    name: routes.Chart.Index,
    component: SingleChartView,
  },
];

export default chartRoutes;
