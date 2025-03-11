import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';

export const granularityEndpoints = [
  {
    granularity: Granularity.Municipalitie,
    collectionUrl: '/administrative-division/municipality',
    tileUrl: '/territory.municipality',
  },
  {
    granularity: Granularity.PublicInstitutionForIntermunicipaleCooperation,
    collectionUrl: '/administrative-division/piic',
    tileUrl: '/territory.piic',
  },
  {
    granularity: Granularity.Department,
    collectionUrl: '/administrative-division/department',
    tileUrl: '/territory.department',
  },
];
