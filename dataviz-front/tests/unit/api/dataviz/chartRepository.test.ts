import { BASE_URL, postPolar, postCartesian } from '@/api/dataviz/chartRepository';
import { api } from '@/api/dataviz/datavizClient';

vi.mock('@/api/dataviz/datavizClient', () => ({
  api: {
    post: vi.fn(),
  },
}));

describe('chartRepository', () => {
  it('should post polar data correctly', async () => {
    const slug = 'slug-example';
    const payload = {
      values: { column: 'col1', operation: 'sum', dataEntry: 'data1' },
      serie: { column: 'col2', dataEntry: 'data2' },
      filters: [{ column: 'col3', values: ['value1'] }],
    };
    const mockResponse = { data: 'response data' };

    (api.post as vi.Mock).mockResolvedValue(mockResponse);

    const result = await postPolar(slug, payload);

    expect(api.post).toHaveBeenCalledWith(
      `${BASE_URL}/${slug}/polar`,
      payload,
      expect.any(Object)
    );
    expect(result).toEqual(mockResponse);
  });

  it('should post cartesian data correctly', async () => {
    const slug = 'slug-example';
    const payload = {
      distribution: { column: 'col1' },
      operation: { column: 'col2', operation: 'sum' },
    };
    const mockResponse = { data: 'cartesian response data' };

    (api.post as vi.Mock).mockResolvedValue(mockResponse);

    const result = await postCartesian(slug, payload);

    expect(api.post).toHaveBeenCalledWith(
      `${BASE_URL}/${slug}/cartesian`,
      payload,
      expect.any(Object)
    );
    expect(result).toEqual(mockResponse);
  });
});
