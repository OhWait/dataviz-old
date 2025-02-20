import { api } from '@/api/dataviz/datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { ITheme } from '@/@types/dataviz/theme/model.js';

const BASE_URL: string = 'theme';

export const getCollection = async (): Promise<HydraCollection<ITheme>> => api.get<HydraCollection<ITheme>>(BASE_URL);

export const getItem = async (slug: string): Promise<ITheme> => api.get<ITheme>(`${BASE_URL}/${slug}`);

