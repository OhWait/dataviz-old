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

export interface IAdministrativeDivisionPayload {
  label?: string;
  itemsPerPage?: number;
  page?: number;
}

export interface IGlobalPayload extends IAdministrativeDivisionPayload {
  granularity?: Granularity;
}

interface IAdministrativeDivisionState {
  municipalities: HydraCollection<IMunicipality> | null;
  isLoadingMunicipality: boolean;
  municipalityError: Error | null;
  piic: HydraCollection<IPiic> | null;
  piicLoading: boolean;
  piicError: Error | null;
  department: HydraCollection<IDepartment> | null;
  departmentLoading: boolean;
  departmentError: Error | null;
}

export const useAdministrativeDivisionStore = defineStore(
  'administrativeDivision',
  {
    state: (): IAdministrativeDivisionState => ({
      municipalities: null,
      isLoadingMunicipality: false,
      municipalityError: null,

      piic: null,
      piicLoading: false,
      piicError: null,

      department: null,
      departmentLoading: false,
      departmentError: null,
    }),

    actions: {
      async fetchAdministrativeDivision(payload: IGlobalPayload) {
        const { granularity } = payload;

        switch (granularity) {
          case Granularity.Municipalitie:
            return this.fetchMunicipalities(payload);
          case Granularity.PublicInstitutionForIntermunicipaleCooperation:
            return this.fetchPiics();
          case Granularity.Department:
            return this.fetchDepartments();
          default:
            return null;
        }
      },

      async fetchMunicipalities(payload: IAdministrativeDivisionPayload) {
        const { label, itemsPerPage, page } = payload;
        this.isLoadingMunicipality = true;
        this.municipalityError = null;
        try {
          const result = await getMunicipalities(label, itemsPerPage, page);
          this.municipalities = result;
          return result;
        } catch (e) {
          this.municipalityError = e as Error;
          throw e;
        } finally {
          this.isLoadingMunicipality = false;
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
      getMunicipalities: state => state.municipalities,
      getLoadingMunicipality: state => state.isLoadingMunicipality,
      getMunicipalityError: state => state.municipalityError,
      getPiic: state => state.piic,
      getPiicLoading: state => state.piicLoading,
      getPiicError: state => state.piicError,
      getDepartment: state => state.department,
      getDepartmentLoading: state => state.departmentLoading,
      getDepartmentError: state => state.departmentError,
    },
  }
);
