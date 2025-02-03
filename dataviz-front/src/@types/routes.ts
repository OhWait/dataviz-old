import ChartRoutes from '@/@types/chart/routes.js';
import { DatasetRoutes } from './dataset/routes';

enum MainRoutes {
  Home = 'home',
}

export default {
  ...MainRoutes,

  Dataset: DatasetRoutes,
  Chart: ChartRoutes,
};
