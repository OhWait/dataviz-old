import { View } from '../@types/dataviz/chart/enum/ViewEnum';
import { i18n } from '@/plugins/i18n.js';

const { t } = i18n.global;

interface IViewList {
  type: View;
  icon: string;
  preview: string;
  title: string;
}

export const viewList: IViewList[] = [
  {
    type: View.PieChart,
    icon: '/media/charts/icon/pie.svg',
    preview: '/media/charts/preview/pie.svg',
    title: t('chart.icon.pie'),
  },
  {
    type: View.DonutChart,
    icon: '/media/charts/icon/donut.svg',
    preview: '/media/charts/preview/donut.svg',
    title: t('chart.icon.donut'),
  },
  {
    type: View.ColumnChart,
    icon: '/media/charts/icon/bar_vertical.svg',
    preview: '/media/charts/preview/bar_vertical.svg',
    title: t('chart.icon.histogram'),
  },
  {
    type: View.StackedColumnChart,
    icon: '/media/charts/icon/bar_stacked_vertical.svg',
    preview: '/media/charts/preview/bar_stacked_vertical.svg',
    title: t('chart.icon.stacked_histogram'),
  },
  {
    type: View.BarChart,
    icon: '/media/charts/icon/bar_horizontal.svg',
    preview: '/media/charts/preview/bar_horizontal.svg',
    title: t('chart.icon.bar'),
  },
  {
    type: View.StackedBarChart,
    icon: '/media/charts/icon/bar_stacked_horizontal.svg',
    preview: '/media/charts/preview/bar_stacked_horizontal.svg',
    title: t('chart.icon.stacked_bar'),
  },
  {
    type: View.LineChart,
    icon: '/media/charts/icon/line.svg',
    preview: '/media/charts/preview/line.svg',
    title: t('chart.icon.line'),
  },
];

export const reversedCartesianAxe = [View.BarChart, View.StackedBarChart];
