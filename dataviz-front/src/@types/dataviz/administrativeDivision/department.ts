export interface IDepartmentCollection extends IDepartment {
  nbMunicipalities: number;
};

export interface IDepartment {
  // year: number;
  codedep: string;
  label: string;
};
