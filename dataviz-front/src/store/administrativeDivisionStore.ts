import {
  IDepartmentCollection,
  IMunicipality,
  IPiicCollection,
} from '@/@types/dataviz/administrativeDivision';
import { Granularity } from '@/@types/dataviz/dataset/enum/GranularityEnum';
import HydraCollection from '@/@types/hydra/collectionResponse';
import {
  getDepartments,
  getMunicipalities,
  getPiics,
  IAdministrativeDivisionPayload,
} from '@/api/dataviz/administrativeDivisionRepository';
import { defineStore } from 'pinia';

export interface IGlobalPayload extends IAdministrativeDivisionPayload {
  granularity?: Granularity;
}

interface IAdministrativeDivisionState {
  municipalities: HydraCollection<IMunicipality> | null;
  isLoadingMunicipality: boolean;
  municipalityError: Error | null;
  piics: HydraCollection<IPiicCollection> | null;
  isLoadingPiic: boolean;
  piicError: Error | null;
  departments: HydraCollection<IDepartmentCollection> | null;
  isLoadingDepartment: boolean;
  departmentError: Error | null;
}

export const useAdministrativeDivisionStore = defineStore(
  'administrativeDivision',
  {
    state: (): IAdministrativeDivisionState => ({
      municipalities: null,
      isLoadingMunicipality: false,
      municipalityError: null,

      piics: null,
      isLoadingPiic: false,
      piicError: null,

      departments: null,
      isLoadingDepartment: false,
      departmentError: null,
    }),

    actions: {
      async fetchAdministrativeDivision(globalPayload: IGlobalPayload) {
        const { granularity, ...payload } = globalPayload;

        switch (granularity) {
          case Granularity.Municipalitie:
            return this.fetchMunicipalities(payload);
          case Granularity.Piic:
            return this.fetchPiics(payload);
          case Granularity.Department:
            return this.fetchDepartments(payload);
          default:
            return null;
        }
      },

      async fetchMunicipalities(payload: IAdministrativeDivisionPayload) {
        this.isLoadingMunicipality = true;
        this.municipalityError = null;
        try {
          const result = await getMunicipalities(payload);
          this.municipalities = result;
          return result;
        } catch (e) {
          this.municipalityError = e as Error;
          throw e;
        } finally {
          this.isLoadingMunicipality = false;
        }
      },

      async fetchPiics(payload: IAdministrativeDivisionPayload) {
        this.isLoadingPiic = true;
        this.piicError = null;
        try {
          const result = await getPiics(payload);
          this.piics = result;
          return result;
        } catch (e) {
          this.piicError = e as Error;
          throw e;
        } finally {
          this.isLoadingPiic = false;
        }
      },

      async fetchDepartments(payload: IAdministrativeDivisionPayload) {
        this.isLoadingDepartment = true;
        this.departmentError = null;
        try {
          const result = await getDepartments(payload);
          this.departments = result;
          return result;
        } catch (e) {
          this.departmentError = e as Error;
          throw e;
        } finally {
          this.isLoadingDepartment = false;
        }
      },
    },

    getters: {
      getMunicipalities: state => state.municipalities,
      getLoadingMunicipality: state => state.isLoadingMunicipality,
      getMunicipalityError: state => state.municipalityError,
      getPiics: state => state.piics,
      getLoadingPiic: state => state.isLoadingPiic,
      getPiicError: state => state.piicError,
      getDepartments: state => state.departments,
      getLoadingDepartment: state => state.isLoadingDepartment,
      getDepartmentError: state => state.departmentError,
    },
  }
);
