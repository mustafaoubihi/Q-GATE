<style>
.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
}
body{
  margin: 0;
  padding-top: 100px;

}

.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}

.logo.electron:hover {
  filter: drop-shadow(0 0 2em #9FEAF9);
}

.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}

button {
  padding: 0.5rem 1rem;
  background-color: #171717;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  max-height: 45px;
}

button:hover {
  background-color: #2980b9;
}
</style>
<template>
  <router-view/>
</template>

<script>
export default {
  name: 'App'
};
</script>
