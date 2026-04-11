// axios
import axios from 'axios'
import { notify } from '@kyvg/vue3-notification'
import router from './router'
import store from './store'

const baseURL = '/api'

const a = axios.create({
  baseURL
})

a.interceptors.request.use((config) => {
  const token = localStorage.getItem('api-token')

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  } else if (config.headers.Authorization) {
    delete config.headers.Authorization
  }

  return config
})

a.interceptors.response.use(
  (res) => {
    if (res.data.show_message) {
      notify({
        title: 'Success',
        text: res.data.message
      })
    }
    // return res;
    return Promise.resolve(res)
  },
  (error) => {
    notify({
      title: 'Whoops!',
      type: 'error',
      text: error.response.data.message
    })

    if (error.response.status == 401) {
      localStorage.removeItem('api-token')
      store.commit('setUser', null)
      router.push({ name: 'login' })
    }

    return Promise.reject(error)
  }
)

export default a
