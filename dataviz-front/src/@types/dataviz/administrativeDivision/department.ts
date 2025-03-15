export interface IDepartmentCollection extends IDepartment {
  nbMunicipalities: number;
};

export interface IDepartment {
  dep: string;
  label: string;
};
