import { RouteRecordRaw } from 'vue-router';
import routes from '@/@types/routes';
import SingleChartView from '@/views/chart/SingleChartView.vue';
import ChartView from '@/views/chart/ChartView.vue';

const chartRoutes: RouteRecordRaw[] = [
  {
    path: '/chart',
    name: routes.Chart.Index,
    component: SingleChartView,
  },
  {
    path: '/graph',
    name: routes.Chart.Bis,
    component: ChartView,
  },
];

export default chartRoutes;
