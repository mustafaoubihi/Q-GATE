import { createRouter, createWebHistory } from 'vue-router';
import Users from '../components/Users.vue';
import Manager from '../components/Manager.vue';
import Login from '../components/Login.vue';
import Inception from '../components/Inspection.vue'; // Note the correct spelling

const routes = [
  {
    path: '/users',
    name: 'Users',
    component: Users,
    meta: { requiresAdmin: true }
  },
  {
    path: '/',
    name: 'Manager',
    component: Manager,
    meta: { requiresAdmin: true }
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/inception',
    name: 'Inception',
    component: Inception
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

router.beforeEach((to, from, next) => {
  const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);
  const authUser = JSON.parse(localStorage.getItem('user')); // Get user info from local storage
  console.log(authUser?.user.employerBadge.startsWith('admin'));

  if (!authUser && to.path !== '/login') {
    next('/login');
  } else if (requiresAdmin && (!authUser || !authUser?.user.employerBadge.startsWith('admin'))) {
    next('/inception');
  } else {
    next();
  }
});

export default router;
