import axios from "axios"
import { OK } from '../util'

const state = {
    user: null,
    status: null
}

const getters = {
    // check: state => !!state.user,
    check: state => {
        if (state.user != null) {
            return true
        } else {
            return false
        }
    },
    checkVerified: state => {
        if (state.user != null) {
            if (state.user.email_verified_at != null) {
                return true
            } else {
                return false
            }
        } else {
            return false
        }
    },
    username: state => state.user ? state.user.name : '',
    userid: state => state.user ? state.user.id: ''
}

const mutations = {
    setUser(state, user) {
        state.user = user
    },
    setStatus(state, status) {
        state.status = status
    }
}

const actions = {
    async register(context, data) {
        const response = await axios.post('/api/register', data)
        context.commit('setUser', response.data)
    },
    async login(context, data) {
        // const response = await axios.post('/api/login', data)
        // context.commit('setUser', response.data)
        context.commit('setStatus', null)
        const response = await axios.post('/api/login', data)
            .catch(err => err.response || err)
        if (response.status === OK) {
            context.commit('setStatus', true)
            context.commit('setUser', response.data)
            return false
        }

        context.commit('setStatus', false)
        context.commit('error/setCode', response.status, { root: true })
    },
    async logout(context) {
        const response = await axios.post('/api/logout')
        context.commit('setUser', null)
    },
    async currentUser(context) {
        const response = await axios.get('/api/user')
        const user = response.data || null
        context.commit('setUser', user)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}