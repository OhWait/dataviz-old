import MockAdapter from 'axios-mock-adapter';
import { api, client } from '@/api/dataviz/datavizClient';

describe('API client', () => {
  let mock: MockAdapter;

  beforeEach(() => {
    mock = new MockAdapter(client);
  });

  afterEach(() => {
    mock.reset();
  });

  it('should get data successfully', async () => {
    const data = { message: 'Success' };
    mock.onGet('/test-url').reply(200, data);

    const response = await api.get('/test-url');
    expect(response).toEqual(data);
  });

  it('should post data successfully', async () => {
    const requestData = { input: 'data' };
    const responseData = { message: 'Posted' };
    mock.onPost('/test-url', requestData).reply(200, responseData);

    const response = await api.post('/test-url', requestData);
    expect(response).toEqual(responseData);
  });

  it('should handle errors', async () => {
    mock.onGet('/test-url').reply(500);

    try {
      await api.get('/test-url');
    } catch (error) {
      // @ts-expect-error unable to type
      expect(error.response.status).toBe(500);
    }
  });
});
