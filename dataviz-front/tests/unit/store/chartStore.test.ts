import { postPolar } from '@/api/dataviz/chartRepository';
import { useChartStore } from '@/store/chartStore';
import { polarDataTransformer } from '@/utils/chart/dataTransformer';
import { createPinia, setActivePinia } from 'pinia';
import { datasetFactory } from '@test/data/dataviz/datasetFactory';
import { View } from '@/@types/dataviz/chart';

vi.mock('@/api/dataviz/chartRepository', () => ({
  postPolar: vi.fn(),
}));

vi.mock('@/utils/chart/dataTransformer', () => ({
  polarDataTransformer: vi.fn(),
}));

describe('useChartStore', () => {
  let store: any;
  const dataset = datasetFactory.build();
  const uuid = 'uuid-example';

  beforeEach(() => {
    setActivePinia(createPinia());
    store = useChartStore();
    store.initChart(uuid, dataset);
  });

  // =======================
  // Drawers Tests
  // =======================
  describe('Drawers', () => {
    it('should set active theme correctly', () => {
      const theme = 'dark';
      store.setActiveTheme(theme);

      expect(store.drawers.theme.currentTheme).toBe(theme);
      expect(store.drawers.dataset.drawer).toBe(true);
      expect(store.drawers.dataset.rail).toBe(false);
    });

    it('should toggle drawer visibility correctly', () => {
      store.toggleDrawer('dataset', true);

      expect(store.drawers.dataset.drawer).toBe(true);
      expect(store.drawers.dataset.rail).toBe(false);

      store.toggleDrawer('dataset', false);

      expect(store.drawers.dataset.drawer).toBe(true);
      expect(store.drawers.dataset.rail).toBe(true);
    });

    it('should set drawer dataset correctly', () => {
      store.setDrawerDataset(dataset);

      expect(store.drawers.dataset.currentDataset).toBe(dataset.slug);
      expect(store.drawers.visualization.drawer).toBe(true);
    });

    it('should set drawer view correctly', () => {
      const view = View.Pie;
      store.setDrawerView(view);

      expect(store.drawers.visualization.view).toBe(view);
      expect(store.drawers.filter.drawer).toBe(true);
      expect(store.drawers.filter.rail).toBe(false);
    });
  });

  // =======================
  // Getters Tests
  // =======================
  describe('Getters', () => {
    it('should initialize a chart correctly', () => {
      const chart = store.getChart(uuid);

      expect(chart).not.toBeNull();
      expect(chart?.uuid).toBe(uuid);
      expect(chart?.dataset).toEqual(dataset);
    });

    it('should initialize a new chart correctly with different dataset', () => {
      const newDataset = datasetFactory.build();
      store.initChart(uuid, newDataset);

      const chart = store.getChart(uuid);
      expect(chart?.dataset).toEqual(newDataset);
    });
  });

  // =======================
  // Post Polar Tests
  // =======================
  describe('Post Polar', () => {
    it('should post polar form correctly', async () => {
      const form = {
        values: { column: 'col1', operation: 'sum', dataEntry: 'data1' },
        serie: { column: 'col2', dataEntry: 'data2' },
        filters: [{ column: 'col3', values: ['value1'] }],
      };

      const mockResponse = { data: 'response data' };
      (postPolar as vi.Mock).mockResolvedValue(mockResponse);
      (polarDataTransformer as vi.Mock).mockReturnValue(form);

      await store.postForm(dataset.slug, uuid, form);

      expect(postPolar).toHaveBeenCalledWith(dataset.slug, form);
      expect(store.getChart(uuid)?.response).toEqual(mockResponse);
    });

    it('should handle postPolar failure correctly', async () => {
      const form = {
        values: { column: 'col1', operation: 'sum', dataEntry: 'data1' },
        serie: { column: 'col2', dataEntry: 'data2' },
        filters: [{ column: 'col3', values: ['value1'] }],
      };

      const mockError = new Error('API Error');
      (postPolar as vi.Mock).mockRejectedValue(mockError);

      try {
        await store.postForm(dataset.slug, uuid, form);
      } catch (error) {
        expect(error).toEqual(mockError);
      }

      const chart = store.getChart(uuid);
      expect(chart?.response).toBeUndefined();
    });
  });

  // =======================
  // Chart Update Tests
  // =======================
  describe('Chart Update', () => {
    it('should update filters correctly', () => {
      const filters = [{ column: 'col1', values: ['value1', 'value2'] }];
      store.updateChart(uuid, View.Pie).updateFilters(uuid, filters);

      const chart = store.getChart(uuid);
      expect(chart?.payload?.filters).toEqual(filters);
    });

    it('should update chart view to Polar (Pie) and transform payload', () => {
      store.updateChart(uuid, View.Pie);

      const chart = store.getChart(uuid);
      expect(chart?.view).toBe(View.Pie);
      expect(chart?.payload?.values).toEqual({
        column: null,
        operation: null,
        dataEntry: null,
      });
    });

    it('should handle unknown view type in updateChart', () => {
      const consoleWarnSpy = vi.spyOn(console, 'warn').mockImplementation();

      store.updateChart(uuid, 'UnknownView' as any);

      expect(consoleWarnSpy).toHaveBeenCalledWith(
        'No handler for view type: UnknownView'
      );
    });
  });
});
