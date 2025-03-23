import { IDepartment } from "./department";
import { IPiic } from "./piic";

export interface IMunicipalityCollection {
  codgeo: string;
  label: string;
  piic?: IPiic;
  department: IDepartment;
};

export interface IMunicipality {
  codgeo: string;
  label: string;
}

