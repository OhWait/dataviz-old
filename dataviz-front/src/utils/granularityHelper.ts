import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import { i18n } from '@/plugins/i18n';

const { t } = i18n.global;

export const granularityEndpoints = [
  {
    granularity: Granularity.Municipalitie,
    title: t('granularity.municipality'),
    tileUrl: '/territory.municipality',
  },
  {
    granularity: Granularity.Piic,
    title: t('granularity.piic'),
    tileUrl: '/territory.piic',
  },
  {
    granularity: Granularity.Department,
    title: t('granularity.department'),
    tileUrl: '/territory.department',
  },
];
