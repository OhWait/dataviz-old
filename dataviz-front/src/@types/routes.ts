import ChartRoutes from '@/@types/dataviz/chart/routes.js';
import DatasetRoutes from '@/@types/dataviz/dataset/enum/routes';

enum MainRoutes {
  Home = 'home',
}

export default {
  ...MainRoutes,

  Dataset: DatasetRoutes,
  Chart: ChartRoutes,
};
