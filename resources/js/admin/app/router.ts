import LoginLayout from '@/admin/layouts/LoginLayout.vue';
import { createRouter, createWebHistory } from 'vue-router';
import { useMainStore } from '@/admin/stores/main';
import FrontendLayout from '@/admin/layouts/FrontendLayout.vue';

import NotFound from '@/admin/pages/404.vue';
import Home from '@/admin/pages/home/Index.vue';
import User from '@/admin/pages/user/Index.vue';
import UserEdit from '@/admin/pages/user/UserEdit.vue';
import Login from '@/admin/pages/auth/Login.vue';
import { useAuthStore } from '@/admin/stores/auth';
import { DEFAULT_PAGE_TITLE } from '@/admin/config/constant';

const routes = [
    {
        path: '/login',
        component: LoginLayout,
        meta: { guestOnly: true },
        children: [
            {
                path: '',
                name: 'login',
                component: Login,
            },
        ],
    },
    {
        path: '/',
        component: FrontendLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
                meta: {
                    pageTitle: DEFAULT_PAGE_TITLE,
                    bodyClass: 'home',
                },
            },
        ],
    },
    {
        path: '/users',
        component: FrontendLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                name: 'user',
                component: User,
                meta: {
                    pageTitle: 'User',
                    bodyClass: 'user',
                },
            },
            {
                path: 'detail/:id',
                name: 'user.detail',
                component: User,
                meta: {
                    pageTitle: 'User detail',
                    bodyClass: 'user',
                },
            },
            {
                path: 'edit/:id',
                name: 'user.edit',
                component: UserEdit,
                meta: {
                    pageTitle: 'User edit',
                    bodyClass: 'user',
                },
            },
        ],
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'page-not-found',
        component: NotFound,
    },
]

const router = createRouter({
    history: createWebHistory('/admin'),
    routes,
})

// Navigation guard
router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore()
    const mainStore = useMainStore()

    // Initialize auth state if not already done
    if (!auth.initialized) {
        await auth.fetchMe()
    }

    // Set meta info
    const pageTitle = typeof to.meta.pageTitle === 'string' ? to.meta.pageTitle : DEFAULT_PAGE_TITLE
    const pageDescription = typeof to.meta.pageDescription === 'string' ? to.meta.pageDescription : ''
    mainStore.setPageTitle(pageTitle)
    mainStore.setPageDescription(pageDescription)

    // Check if route requires authentication
    if (to.meta.requiresAuth && !auth.token) {
        // Redirect to login if not authenticated
        return next({ name: 'login' })
    }

    // Check if route is guest-only (login page)
    if (to.meta.guestOnly && auth.token) {
        // Redirect to home if already authenticated
        return next({ name: 'home' })
    }

    next()
})

router.afterEach((to) => {
    const body = document.body;
    body.className = '';
    if (to.meta.bodyClass && typeof to.meta.bodyClass === 'string') {
        body.classList.add(to.meta.bodyClass)
    }
})


export default router
