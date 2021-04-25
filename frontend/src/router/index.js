import Vue from 'vue'
import VueRouter from 'vue-router'
import Prueba from '../views/Pruebas.vue'


Vue.use(VueRouter)

const routes = [{
        path: '/Prueba',
        name: 'Prueba',
        component: Prueba
    },
    {
        path: '/programs',
        name: 'ProgramView',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/ProgramView.vue"),
    },
    {
        path: '/cabezales',
        name: 'Cabezales',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/Cabezales.vue"),
    },
    {
        path: '/fertirrigacion',
        name: 'Fertirrigacion',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/Fertirrigacion.vue"),
    },
    {
        path: '/',
        name: 'Home',
        component: () =>
            import ( /* webpackChunkName: "about" */ "../views/Home.vue"),
    }
]

const router = new VueRouter({
    routes
})

export default router