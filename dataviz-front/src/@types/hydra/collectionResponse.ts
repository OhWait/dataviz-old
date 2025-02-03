export interface HydraCollection<T> {
  'hydra:member': T[];
  'hydra:totalItems': number;
}

export interface AnonymousMember {
  [key: string]: string | number | boolean | null | object;
}

export interface HydraAnonymousCollection {
  'hydra:member': AnonymousMember[];
  'hydra:totalItems': number;
}

export default HydraCollection;
