import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Inspection from '../components/Inspection.vue';
import Manager from '../components/Manager.vue';
import Users from '../components/Users.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/inception', component: Inspection },
  { path: '/manager', component: Manager },
  { path: '/', component: Users }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
