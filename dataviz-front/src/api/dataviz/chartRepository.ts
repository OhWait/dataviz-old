import {
  ICartesianPayload,
  ICartesianResponse,
  IPolarPayload,
  IPolarResponse,
} from '@/@types/dataviz/chart/index';
import { api } from '@/api/dataviz/datavizClient';

class ChartRepository {
  static BASE_URL: string = 'chart';

  async postPolar(
    slug: string,
    payload: IPolarPayload
  ): Promise<IPolarResponse> {
    return api.post(`${ChartRepository.BASE_URL}/${slug}/polar`, payload, {
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    });
  }

  async postCartesian(
    slug: string,
    payload: ICartesianPayload
  ): Promise<ICartesianResponse> {
    return api.post(`${ChartRepository.BASE_URL}/${slug}/cartesian`, payload, {
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    });
  }
}

export const chartRepository = new ChartRepository();
