import Vue from 'vue'
import VueRouter from 'vue-router'

import Login from './pages/Login.vue'
import ItemList from './pages/ItemList.vue'
import ItemCreate from './pages/ItemCreate.vue'
import ItemShow from './pages/ItemShow.vue'

import store from './store'

Vue.use(VueRouter)

const routes = [
    {
        path: '/items',
        component: ItemList,
        props: route => {
            const page = route.query.page
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
        }
    },
    {
        path: '/login',
        component: Login,
        beforeEnter(to, from, next) {
            if (store.getters['auth/check']) {
                next('/')
            } else {
                next()
            }
        },
        name: 'login'
    },
    {
        path: '/items/create',
        component: ItemCreate,
    },
    {
        path: '/items/:id',
        component: ItemShow,
        props: true
    },
]

const router = new VueRouter({
    mode: 'history',
    scrollBehavior() {
        return { x: 0, y: 0 }
    },
    routes
})

export default router