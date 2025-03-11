import {
  IDepartment,
  IMunicipality,
  IPiic,
} from '@/@types/dataviz/administrativeDivision';
import { api } from './datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';

const BASE_URL = 'administrative-division';

export const getMunicipalities = async (): Promise<
  HydraCollection<IMunicipality>
> => api.get<HydraCollection<IMunicipality>>(`${BASE_URL}/municipality`);

export const getPiics = async (): Promise<HydraCollection<IPiic>> =>
  api.get<HydraCollection<IPiic>>(`${BASE_URL}/piic`);

export const getDepartments = async (): Promise<HydraCollection<IDepartment>> =>
  api.get<HydraCollection<IDepartment>>(`${BASE_URL}/department`);
