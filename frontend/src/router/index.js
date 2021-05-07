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
            import ("../views/ProgramView.vue"),
    },
    {
        path: '/cabezales',
        name: 'Cabezales',
        title: "test",
        component: () =>
            import ("../views/Cabezales.vue"),
    },
    {
        path: '/programas',
        name: 'Programas',
        component: () =>
            import ("../views/Programas.vue"),
    },
    {
        path: '/fertirrigacion',
        name: 'Fertirrigacion',
        component: () =>
            import ("../views/Fertirrigacion.vue"),
    },
    {
        path: '/',
        name: 'Home',
        component: () =>
            import ("../views/Home.vue"),
    },
    {
        path: '/registrarProgramador',
        name: 'Registrar programador',
        component: () =>
            import ("../views/RegistroProgramador/RegistroProgramador.vue"),
    },
]

const router = new VueRouter({
    routes
})

export default router