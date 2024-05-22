<template>
    <nav class="navbar">
      <div class="logo">
        <img src="../assets/pics/cart1.jpg" alt="">
        <h1>QUALITY GATE</h1>
      </div>

      <ul class="nav-links">
        <li><a href="/manager">Inception list</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="/">Logout</a></li>
      </ul>
    </nav>
</template>

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