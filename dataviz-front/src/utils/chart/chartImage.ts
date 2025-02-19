import { View } from "@/@types/dataviz/chart";

const imgPath = '/media/charts/preview';

export const chartImages = {
  [View.Pie]: `${imgPath}/pie.svg`,
  [View.Histogram]: `${imgPath}/bar_vertical.svg`,
  [View.StackedHistogram]: `${imgPath}/bar_stacked_vertical.svg`,
  [View.Bar]: `${imgPath}/bar_horizontal.svg`,
  [View.StackedBar]: `${imgPath}/bar_stacked_horizontal.svg`,
  [View.Line]: `${imgPath}/line.svg`,
};