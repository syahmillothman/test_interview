import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'

const config = {
  auth: bearer,
  http: axios,
  router: router,
  tokenDefaultName: 'laravel-vue-spa',
  tokenStore: ['localStorage'],
  rolesVar: 'role',
  loginData: {url: 'v1/login', method: 'POST', redirect: '', fetchUser: true},
  fetchData: {url: 'v1/me', method: 'GET', enabled: true},
}

export default config