import axios, { AxiosRequestConfig } from 'axios';

const baseURL = import.meta.env.VITE_API_URL;

export const client = axios.create({
  baseURL,
  headers: {
    Accept: 'application/ld+json',
  },
});

client.interceptors.response.use(
  response => response.data,
  error => Promise.reject(error)
);

export const api = {
  get: <T>(url: string, params?: object): Promise<T> =>
    client.get(url, { params }),

  post: <T, TData>(
    url: string,
    data: TData,
    config?: AxiosRequestConfig<TData>
  ): Promise<T> => client.post(url, data, config),
};

export const getImageUrl = (url: string): string => `${baseURL}${url}`;
