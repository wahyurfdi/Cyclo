import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from './../views/Login.vue'
import Home from './../views/Home.vue'
import History from './../views/History.vue'
import Profile from './../views/Profile.vue'
import TrashForm from './../views/request-pickup/TrashForm.vue'
import AddressForm from './../views/request-pickup/AddressForm.vue'
import Result from './../views/request-pickup/Result.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/web-app/login',
        name: 'login',
        component: Login
    },
    {
        path: '/web-app/home',
        name: 'home',
        component: Home
    },
    {
        path: '/web-app/history',
        name: 'history',
        component: History
    },
    {
        path: '/web-app/profile',
        name: 'profile',
        component: Profile
    },
    {
        path: '/web-app/request-pickup/trash-form',
        name: 'request-pickup.trash-form',
        component: TrashForm
    },
    {
        path: '/web-app/request-pickup/address-form',
        name: 'request-pickup.address-form',
        component: AddressForm
    },
    {
        path: '/web-app/request-pickup/result',
        name: 'request-pickup.result',
        component: Result
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router