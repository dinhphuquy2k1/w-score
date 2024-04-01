import {createRouter, createWebHistory, RouteRecordRaw} from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes: Array<RouteRecordRaw> = [
    {
        path: '/',
        name: 'home',
        components: {
            home: () => import('@/views/HomeView.vue'),
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
                path: '/login',
                components: {
                    header: () => import('@/views/admin/components/Header.vue'),
                    content: () => import('@/components/Login.vue'),
                    navbar: () => import('@/views/admin/components/NavBar.vue'),
                },
            },
            {
                path: '/exam-list',
                name: 'exam-list',
                components: {
                    content: () => import('@/views/user/components/ExamList.vue'),
                    header: () => import('@/views/admin/components/Header.vue'),
                    navbar: () => import('@/views/admin/components/NavBar.vue')
                },
                meta: {
                    auth: true,
                    title: 'Quản lý đề thi'
                }
            },
        ],
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
