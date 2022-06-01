import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
export default new Vuex.Store({
    state: {
        errors: {},
        menus: [],
        permissions: [],
        role: null,
        roles: [],
        theme: 'dark',
    },
    getters: {
        errors: state => name => {
            return state.errors[name] && state.errors[name][0]
        },
        permissions: state => {
            return state.permissions
        },
        menus: state => {
            return state.menus
        },
        role: state => {
            return state.role
        },
        roles: state => {
            return state.roles
        },
        theme: state => {
            return state.theme
        }

    },
    mutations: {
        errors(state, errors = {}) {
            state.errors = errors
        },
        permissions(state, permissions = []) {
            state.permissions = permissions
        },
        menus(state, menus = []) {
            state.menus = menus
        },
        role(state, role = '') {
            state.role = role
        },
        roles(state, roles = []) {
            state.roles = roles
        },
        theme(state, theme = 'dark') {
            state.theme = theme
        }
    },
    actions: {
        errors(context, errors = {}) {
            context.commit('errors', errors)
        },
        permissions(context, permissions = []) {
            context.commit('permissions', permissions)
        },
        menus(context, menus = []) {
            context.commit('menus', menus)
        },
        role(context, role = '') {
            context.commit('role', role)
        },
        roles(context, roles = []) {
            context.commit('roles', roles)
        },
        theme(context, theme = 'dark') {
            context.commit('theme', theme)
        }

    }
})
