
import {createRouter as Router, createWebHistory } from 'vue-router';
import LoginForm from '@/components/LoginForm';
import RegistrationForm from '@/components/RegistrationForm';
import UserDashboard from '@/components/UserDashboard';
import HelloWorld from '@/components/HelloWorld';

import store from '@/store';

/* eslint-disable */

const routes = [
    { path: '/', component: HelloWorld },
    { path: '/login', component: LoginForm },
    { path: '/register', component: RegistrationForm },
    { path: '/dashboard', component: UserDashboard, meta: { requiresAuth: true } },
    { path: '/:pathMatch(.*)*', redirect: '/' },
  ]

const router = new Router({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.requiresAuth)) {
    if (!store.state.isUserAuthenticated && to.path !== '/login' && to.path !== '/register' ) { 
      next({ path: '/login' });
      return;
    }
  }

  next();
});

export default router
