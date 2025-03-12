import {
  IDepartment,
  IMunicipality,
  IPiic,
} from '@/@types/dataviz/administrativeDivision';
import { api } from './datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';

const BASE_URL = 'administrative-division';

export const getMunicipalities = async (
  label?: string,
  itemsPerPage?: number,
  page?: number,
): Promise<HydraCollection<IMunicipality>> => {
  const params = new URLSearchParams();

  if (label) {
    params.append('label', label);
  }

  if (itemsPerPage) {
    params.append('itemsPerPage', itemsPerPage.toString());
  }

  if (page) {
    params.append('page', page.toString());
  }

  const queryString = params.toString();
  const url = queryString
    ? `${BASE_URL}/municipality?${queryString}`
    : `${BASE_URL}/municipality`;

  return api.get<HydraCollection<IMunicipality>>(url);
};

export const getPiics = async (): Promise<HydraCollection<IPiic>> =>
  api.get<HydraCollection<IPiic>>(`${BASE_URL}/piic`);

export const getDepartments = async (): Promise<HydraCollection<IDepartment>> =>
  api.get<HydraCollection<IDepartment>>(`${BASE_URL}/department`);
