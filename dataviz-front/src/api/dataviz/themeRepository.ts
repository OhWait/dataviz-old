import { api } from '@/api/dataviz/datavizClient';
import HydraCollection from '@/@types/hydra/collectionResponse';
import { ITheme } from '@/@types/theme/model.js';

class ThemeRepository {
  static BASE_URL: string = 'theme';

  async getCollection(): Promise<HydraCollection<ITheme>> {
    return api.get<HydraCollection<ITheme>>(ThemeRepository.BASE_URL);
  }

  async getItem(slug: string): Promise<ITheme> {
    return api.get<ITheme>(`${ThemeRepository.BASE_URL}/${slug}`);
  }
}

export const themeRepository = new ThemeRepository();
