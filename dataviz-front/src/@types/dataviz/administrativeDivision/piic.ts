export interface IPiicCollection extends IPiic{
  nbMunicipalities: number;
}

export interface IPiic {
  epci: string;
  label: string;
  nature: string;
}
