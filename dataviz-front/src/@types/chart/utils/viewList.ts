import { View } from '../enum/View';
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
    type: View.Pie,
    icon: '/media/charts/icon/pie.svg',
    preview: '/media/charts/preview/pie.svg',
    title: t('chart.icon.pie'),
  },
  {
    type: View.Histogram,
    icon: '/media/charts/icon/bar_vertical.svg',
    preview: '/media/charts/preview/bar_vertical.svg',
    title: t('chart.icon.histogram'),
  },
  {
    type: View.StackedHistogram,
    icon: '/media/charts/icon/bar_stacked_vertical.svg',
    preview: '/media/charts/preview/bar_stacked_vertical.svg',
    title: t('chart.icon.stacked_histogram'),
  },
  {
    type: View.Bar,
    icon: '/media/charts/icon/bar_horizontal.svg',
    preview: '/media/charts/preview/bar_horizontal.svg',
    title: t('chart.icon.bar'),
  },
  {
    type: View.StackedBar,
    icon: '/media/charts/icon/bar_stacked_horizontal.svg',
    preview: '/media/charts/preview/bar_stacked_horizontal.svg',
    title: t('chart.icon.stacked_bar'),
  },
  {
    type: View.Line,
    icon: '/media/charts/icon/line.svg',
    preview: '/media/charts/preview/line.svg',
    title: t('chart.icon.line'),
  },
];
