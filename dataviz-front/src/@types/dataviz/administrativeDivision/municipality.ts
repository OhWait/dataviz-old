import { IDepartment } from "./department";
import { IPiic } from "./piic";

export interface IMunicipalityCollection extends IMunicipality {
  piic?: IPiic;
  department: IDepartment;
};

export interface IMunicipality {
  // year: number;
  codgeo: string;
  label: string;
}

