import {
  IDepartment,
  IMunicipality,
  IPiic,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import HydraCollection from '@/@types/hydra/collectionResponse';
import {
  getDepartments,
  getMunicipalities,
  getPiics,
} from '@/api/dataviz/administrativeDivisionRepository';
import { defineStore } from 'pinia';

export interface IAdministrativeDivision {
  code: string;
  label: string;
}

export interface IAdministrativeDivisionPayload {
  label?: string;
  itemsPerPage?: number;
  page?: number;
}

export interface IGlobalPayload extends IAdministrativeDivisionPayload {
  granularity?: Granularity;
}

interface IAdministrativeDivisionState {
  municipality: HydraCollection<IMunicipality> | null;
  municipalityLoading: boolean;
  municipalityError: Error | null;
  piic: HydraCollection<IPiic> | null;
  piicLoading: boolean;
  piicError: Error | null;
  department: HydraCollection<IDepartment> | null;
  departmentLoading: boolean;
  departmentError: Error | null;
  granularity: Granularity;
  collection: HydraCollection<IAdministrativeDivision> | null;
  collectionLoading: boolean;
  collectionError: Error | null;
}

export const useAdministrativeDivisionStore = defineStore(
  'administrativeDivision',
  {
    state: (): IAdministrativeDivisionState => ({
      municipality: null,
      municipalityLoading: false,
      municipalityError: null,

      piic: null,
      piicLoading: false,
      piicError: null,

      department: null,
      departmentLoading: false,
      departmentError: null,

      // Auto depending granularity
      granularity: Granularity.Municipalitie,
      collection: null,
      collectionLoading: false,
      collectionError: null,
    }),

    actions: {
      async fetchAdministrativeDivision(
        payload: IGlobalPayload = { itemsPerPage: 10, page: 1 }
      ) {
        this.collectionLoading = true;
        this.collectionError = null;

        try {
          let data;

          switch (payload.granularity) {
            default:
            case Granularity.Municipalitie:
              data = await this.fetchMunicipalities(payload);

              this.collection = {
                ...data,
                member: data.member.map((item: IMunicipality) => ({
                  code: item.codgeo,
                  label: item.label,
                })),
              };
              break;

            case Granularity.Department:
              data = await this.fetchDepartments();

              this.collection = {
                ...data,
                member: data.member.map((item: IDepartment) => ({
                  code: item.codedep,
                  label: item.label,
                })),
              };
              break;

            case Granularity.PublicInstitutionForIntermunicipaleCooperation:
              data = await this.fetchPiics();

              this.collection = {
                ...data,
                member: data.member.map((item: IPiic) => ({
                  code: item.codepiic,
                  label: item.label,
                })),
              };
              break;
          }
        } catch (e) {
          this.collectionError = e as Error;
        } finally {
          this.collectionLoading = false;
        }
      },

      async fetchMunicipalities(payload: IAdministrativeDivisionPayload) {
        const { label, itemsPerPage, page } = payload;
        this.municipalityLoading = true;
        this.municipalityError = null;
        try {
          const result = await getMunicipalities(label, itemsPerPage, page);
          this.municipality = result;
          return result;
        } catch (e) {
          this.municipalityError = e as Error;
          throw e;
        } finally {
          this.municipalityLoading = false;
        }
      },

      async fetchPiics() {
        this.piicLoading = true;
        this.piicError = null;
        try {
          const result = await getPiics();
          this.piic = result;
          return result;
        } catch (e) {
          this.piicError = e as Error;
          throw e;
        } finally {
          this.piicLoading = false;
        }
      },

      async fetchDepartments() {
        this.departmentLoading = true;
        this.departmentError = null;
        try {
          const result = await getDepartments();
          this.department = result;
          return result;
        } catch (e) {
          this.departmentError = e as Error;
          throw e;
        } finally {
          this.departmentLoading = false;
        }
      },
    },

    getters: {
      getMunicipality: state => state.municipality,
      getMunicipalityLoading: state => state.municipalityLoading,
      getMunicipalityError: state => state.municipalityError,
      getPiic: state => state.piic,
      getPiicLoading: state => state.piicLoading,
      getPiicError: state => state.piicError,
      getDepartment: state => state.department,
      getDepartmentLoading: state => state.departmentLoading,
      getDepartmentError: state => state.departmentError,
      getCollection: state => state.collection,
      getCollectionLoading: state => state.collectionLoading,
      getCollectionError: state => state.collectionError,
      getCurrentGranularity: state => state.granularity,
    },
  }
);
