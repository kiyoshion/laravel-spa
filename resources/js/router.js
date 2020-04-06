import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './pages/Login'
import ItemList from './pages/ItemList'

import store from './store'

Vue.use(VueRouter)

const routes = [
    { path: '/', component: ItemList },
    {
        path: '/login',
        component: Login,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        }
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router