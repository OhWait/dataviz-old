export interface IPiicCollection extends IPiic{
  nbMunicipalities: number;
}

export interface IPiic {
  // year: number;
  codeepci: string;
  label: string;
  nature: string;
}
