<template>
    <nav class="navbar">
      <div class="logo">
        <img src="../assets/pics/cart1.jpg" alt="">
        <h1>QUALITY GATE</h1>
      </div>

      <ul class="nav-links">
        <li> <router-link to="/" v-if="isAdmin"> Manager</router-link> </li>
        <li> <router-link to="/users" v-if="isAdmin">Users</router-link> </li>
        <li> <router-link to="/inception" v-if="isAdmin">Inception</router-link> </li>
        <!-- <li><a href="/">Inception list</a></li> -->
        <li><a href="#" @click="logout">Logout</a></li>
      </ul>
    </nav>
</template>

<script setup>
import { useRouter} from 'vue-router';
import {ref} from 'vue'
const router = useRouter();

const authUser = JSON.parse(localStorage.getItem('user')); // Get user info from local storage
const isAdmin = ref(authUser?.user.employerBadge.startsWith('admin'))

const logout = ()=>{
  localStorage.removeItem('user');
  router.push('/login');
}
</script>

<style>
.navbar {
  display: flex;
  position: fixed;
  justify-content: space-between;
  align-items: center;
  background-color: black;
  padding: 10px;
  color: white;
  top: 0;
  left: 0;
  width: 99vw;
}

.logo {
  display: flex;
  align-items: center;
  height: 20px;
}

.logo img {
  height: 12px;
  margin-right: 1rem;
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 1rem;
  padding: 0 15px;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

.nav-links a:hover {
  color: #3498db;
}
</style>