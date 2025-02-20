import {
  ICartesianPayload,
  ICartesianResponse,
  IPolarPayload,
  IPolarResponse,
} from '@/@types/dataviz/chart/index';
import { api } from '@/api/dataviz/datavizClient';

const BASE_URL: string = 'chart';

export const postPolar = async (
  slug: string,
  payload: IPolarPayload
): Promise<IPolarResponse> => {
  return api.post(`${BASE_URL}/${slug}/polar`, payload, {
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
  });
}

export const postCartesian = async(
  slug: string,
  payload: ICartesianPayload
): Promise<ICartesianResponse> => {
  return api.post(`${BASE_URL}/${slug}/cartesian`, payload, {
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
  });
}
