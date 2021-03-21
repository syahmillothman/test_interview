import VueRouter from 'vue-router';
import VueRouterMultiGuard from 'vue-router-multiguard';

// Pages
import Home from './pages/Home'
import Login from './pages/Login'
import Main from './pages/Main'
import Users from './pages/Users'
import Todos from './pages/Todos'
import TodoUsers from './pages/TodoUsers'
import auth from './middlewares/auth';
import loggedIn from './middlewares/loggedin';

// Routes
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
    meta: {
      auth: undefined
    }
  },

  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEnter: VueRouterMultiGuard([loggedIn]),
    meta: {
      auth: false
    }
  },
  // // USER ROUTES
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Main,
    beforeEnter: VueRouterMultiGuard([auth])
  },
  {
    path: '/manage-users',
    name: 'manage-users',
    component: Users,
    beforeEnter: VueRouterMultiGuard([auth])
  },
  {
    path: '/manage-todos',
    name: 'manage-todos',
    component: Todos,
    beforeEnter: VueRouterMultiGuard([auth])
  },
  {
    path: '/create-todos',
    name: 'create-todos',
    component: TodoUsers,
    beforeEnter: VueRouterMultiGuard([auth])
  },
  // // ADMIN ROUTES
  // {
  //   path: '/admin',
  //   name: 'admin.dashboard',
  //   component: Main,
  //   meta: {
  //     auth: {roles: 2, redirect: {name: 'login'}, forbiddenRedirect: '/403'}
  //   }
  // },
]


const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router