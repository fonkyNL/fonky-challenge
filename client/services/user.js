import { $axios } from '@/utils/api'

const profile = {
  me: async () => $axios.get('/user/me'),
}

const orders = {
  getTableHeader: async () => $axios.get('/orders/table-header'),
  getTableRows: async (query) => $axios.get(`/orders/table-rows?${query}`),
}

export const UserService = {
  profile,
  orders
}