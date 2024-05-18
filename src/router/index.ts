import { createRouter, createWebHistory } from 'vue-router';
import Login from '../components/Login.vue';
import Inspection from '../components/Inspection.vue';
import Manager from '../components/Manager.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/', component: Inspection },
  { path: '/Manager', component: Manager }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
