import { HYDRA_KEYS } from "../../api/hydraKeys";

export interface HydraCollection<T> {
  [HYDRA_KEYS.MEMBER]: T[];
  [HYDRA_KEYS.TOTAL_ITEMS]: number;
}

export interface AnonymousMember {
  [key: string]: string | number | boolean | null | object;
}

export interface HydraAnonymousCollection {
  [HYDRA_KEYS.MEMBER]: AnonymousMember[];
  [HYDRA_KEYS.TOTAL_ITEMS]: number;
}

export default HydraCollection;
