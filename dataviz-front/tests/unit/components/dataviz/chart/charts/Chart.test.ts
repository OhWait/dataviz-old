import VChart from 'vue-echarts';
import { mount } from '@vue/test-utils';
import { nextTick } from 'vue';
import { cartesianResponseFactory, polarResponseFactory } from '@test/data/dataviz/chartResponseFactory';

// Mock VueECharts pour éviter d'avoir à tester son rendu interne
vi.mock('vue-echarts', () => ({
  default: {
    name: 'VChart',
    props: ['option'],
    template: '<div></div>',
  },
}));

const chartComponents = [
  {
    name: 'BarChart',
    data: cartesianResponseFactory.build(),
    component: () => import('@/components/dataviz/chart/charts/BarChart.vue'),
  },
  {
    name: 'ColumnChart',
    data: cartesianResponseFactory.build(),
    component: () =>
      import('@/components/dataviz/chart/charts/ColumnChart.vue'),
  },
  {
    name: 'DonutChart',
    data: polarResponseFactory.build(),
    component: () => import('@/components/dataviz/chart/charts/DonutChart.vue'),
  },
  {
    name: 'LineChart',
    data: cartesianResponseFactory.build(),
    component: () => import('@/components/dataviz/chart/charts/LineChart.vue'),
  },
  {
    name: 'PieChart',
    data: polarResponseFactory.build(),
    component: () => import('@/components/dataviz/chart/charts/PieChart.vue'),
  },
  {
    name: 'StackedBarChart',
    data: cartesianResponseFactory.build(),
    component: () =>
      import('@/components/dataviz/chart/charts/StackedBarChart.vue'),
  },
  {
    name: 'StackedColumnChart',
    data: cartesianResponseFactory.build(),
    component: () =>
      import('@/components/dataviz/chart/charts/StackedColumnChart.vue'),
  },
];

describe.each(chartComponents)('$name', ({ name, data, component }) => {
  it('should mount correctly with props', async () => {
    const Comp = (await component()).default;
    const wrapper = mount(Comp, {
      props: { data },
    });

    await nextTick();
    expect(wrapper.exists()).toBe(true);
  });

  it('should correctly pass options to the VChart component', async () => {
    const Comp = (await component()).default;
    const wrapper = mount(Comp, {
      props: { data },
    });

    await nextTick();
    const vChart = wrapper.findComponent(VChart);
    expect(vChart.exists()).toBe(true);

    const options: any = vChart.props('option');
    expect(options).toBeDefined();
    expect(options.series).toHaveLength(data.series.length);
    expect(options.series[0].name).toBe(data.series[0].label || 'Unknown');
  });
});
