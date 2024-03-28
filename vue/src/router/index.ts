import {createRouter, createWebHistory, RouteRecordRaw} from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/about',
        name: 'about',
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
    },
    {
        path: '/admin',
        name: 'admin',
        components: {
            home: () => import('@/views/admin/HomeView.vue'),
        },
        children: [
            {
                path: '',
                components: {
                    header: () => import('@/views/admin/components/Header.vue'),
                    content: () => import('@/views/admin/components/GradeMaster.vue'),
                    navbar: () => import('@/views/admin/components/NavBar.vue'),
                },
            },
            {
                path: 'setting',
                components: {
                    header: () => import('@/views/admin/components/Header.vue'),
                    content: () => import('@/views/admin/components/ProductList.vue'),
                    navbar: () => import('@/views/admin/components/NavBar.vue'),
                },
            },
        ],
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})

export default router
