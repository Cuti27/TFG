import Vue from 'vue'
import VueRouter from 'vue-router'
import Prueba from '../views/Pruebas.vue'


Vue.use(VueRouter)

const routes = [{
        path: '/',
        name: 'Home',
        component: Prueba
    },
    {
        path: '/programs',
        name: 'ProgramView',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/ProgramView.vue"),
    },
    {
        path: '/fertirrigacion',
        name: 'Fertirrigacion',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/Fertirrigacion.vue"),
    }
]

const router = new VueRouter({
    routes
})

export default router