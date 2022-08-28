import { NuxtAxiosInstance } from '@nuxtjs/axios'

let $axios = NuxtAxiosInstance

export function initializeAxios(axiosInstance) {
  $axios = axiosInstance
}

export { $axios }
