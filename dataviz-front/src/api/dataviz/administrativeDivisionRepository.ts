import {
  IDepartmentCollection,
  IMunicipalityCollection,
  IPiicCollection,
} from '@/@types/dataviz/administrativeDivision';
import { api } from './datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';

const BASE_URL = 'administrative-division';

export interface IAdministrativeDivisionPayload {
  label?: string;
  itemsPerPage?: number;
  page?: number;
}

const getEntities = async <T>(
  endpoint: string,
  filters: Partial<IAdministrativeDivisionPayload> = {}
): Promise<HydraCollection<T>> => {
  const params = new URLSearchParams(
    Object.entries(filters)
      .filter(([, value]) => value !== undefined)
      .map(([key, value]) => [key, value!.toString()])
  );

  const url = `${BASE_URL}/${endpoint}${params.toString() ? `?${params}` : ''}`;
  return api.get<HydraCollection<T>>(url);
};

export const getMunicipalities = (payload: IAdministrativeDivisionPayload) =>
  getEntities<IMunicipalityCollection>('municipality', payload);

export const getPiics = (payload: IAdministrativeDivisionPayload) =>
  getEntities<IPiicCollection>('piic', payload);

export const getDepartments = (payload: IAdministrativeDivisionPayload) =>
  getEntities<IDepartmentCollection>('department', payload);
