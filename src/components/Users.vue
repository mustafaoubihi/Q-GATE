<template>
    <div class="container">
      <Navbar/>
      <div class="table-container">
        <div class="page-head">
          <h2>Employers Table</h2>
          <button @click="showModal = true">Add New Employer</button>
        </div>
      <table class="fancy-table">
        <thead>
          <tr>
            <th></th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Employer Badge</th>
            <th>Picture</th>
            <th>CIN</th>
            <th>Email</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user,index) in users" :key="user.id">
            <td>{{ index + 1 }}</td>
            <td>{{ user.firstName }}</td>
            <td>{{ user.lastName }}</td>
            <td>{{ user.employerBadge }}</td>
            <td><img :src="getImageUrl(user.image)" alt="Valid Image" class="image-thumbnail" /></td>
            <td>{{ user.CIN }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.role }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  
      <modal v-if="showModal" @close="closeModal">
      <template v-slot:header>
        <h2>Add New Employer</h2>
      </template>
      <template v-slot:body>
        <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="problem">first name:</label>
          <input id="problem" v-model="NewUser.firstName" required />
        </div>
        
        <div class="form-group">
          <label for="zone">last name:</label>
          <input id="lastName" v-model="NewUser.lastName" required />
        </div>
        
        <div class="form-group">
          <label for="email">Email:</label>
          <input id="email" v-model="NewUser.email" required type="email"/>
        </div>
        
        <div class="form-group">
          <label for="post">CIN:</label>
          <input id="post" v-model="NewUser.CIN" required />
        </div>
        
        <div class="form-group">
          <label for="post">Role:</label>
          <input id="post" v-model="NewUser.role" required />
        </div>
        
        <div class="form-group">
          <label for="post">Employer Badge:</label>
          <input id="post" v-model="NewUser.employerBadge" required />
        </div>
        <div class="form-group">
          <label for="post">Password:</label>
          <input id="post" v-model="NewUser.password" required  type="password"/>
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input id="image" type="file" @change="handleFileUpload('image', $event)" required />
        </div>
        
        <button type="submit" class="submit-button">Add User</button>
      </form>
      </template>
    </modal>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref, onMounted } from 'vue';
  import Modal from './Modal.vue';
  import Navbar from '../components/Navbar.vue'
  import axios from 'axios';
  
  const users = ref([]);
  
  const NewUser = ref({
        email:"",
        password:"",
        employerBadge:"",
        firstName:"",
        lastName:"",
        image:"",
        CIN:"",
        role:"",
        password:""
  });
  
  
  const showModal = ref(false);
  
  const fetchUserslists = async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/users');
      users.value = response.data;
    } catch (error) {
      console.error('There was an error fetching the users!', error);
    }
  };
  
  const handleFileUpload = (field, event) => {
    NewUser.value[field] = event.target.files[0];
};

  onMounted(fetchUserslists);
  
  const closeModal = () => {
    showModal.value = false;
  };
  const getImageUrl = (path) => {
    return `http://127.0.0.1:8000/storage/${path}`;
  };
  
  const submitForm = async () => {
    const formData = new FormData();
    formData.append('email', NewUser.value.email);
    formData.append('password', NewUser.value.password);
    formData.append('employerBadge', NewUser.value.employerBadge);
    formData.append('firstName', NewUser.value.firstName);
    formData.append('lastName', NewUser.value.lastName);
    formData.append('image', NewUser.value.image);
    formData.append('CIN', NewUser.value.CIN);
    formData.append('role', NewUser.value.role);
    formData.append('password', NewUser.value.password);
  
    try {
      const response = await axios.post('http://127.0.0.1:8000/api/users', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      console.log('Checklist added', response.data);
      // Reset form after submission
      Object.keys(NewUser.value).forEach(key => {
        NewUser.value[key] = key.includes('image') ? null : '';
      });
      fetchUserslists()
      closeModal()
    } catch (error) {
      console.error('There was an error adding the checklist!', error);
    }
  };
  
  </script>
  
  <style scoped>
  
  body {
    font-family: 'Roboto', sans-serif;
    background-color: var(--background-color);
    color: var(--text-color);
  }
  .page-head{
    display: flex;
    width: 100%;
    justify-content: space-between;
  }
  .container {
    max-width: 1000px;
    margin: 50px auto;
    background-color: white;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    text-align: center;
  }
  
  h1 {
    font-size: 2rem;
    margin-bottom: 20px;
  }
  
  .table-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background: #fff;
  }
  
  h2 {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .fancy-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .fancy-table thead {
    background-color: #010a23;
    color: #fff;
  }
  
  .fancy-table th,
  .fancy-table td {
    padding: 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
  }
  
  .fancy-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  .fancy-table tbody tr:hover {
    background-color: #ddd;
  }
  
  .image-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
  }
  .form-container {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background: #fff;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    text-align: start;
  }
  
  .form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s;
  }
  
  .form-group input[type="file"] {
    padding: 3px;
  }
  
  .form-group input:focus {
    border-color: #1abc9c;
    outline: none;
  }
  
  .submit-button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background: #1abc9c;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .submit-button:hover {
    background: #16a085;
  }
  
  .badge-verified {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #1abc9c;
    color: #fff;
  }
  
  .badge-in-progress {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #f39c12;
    color: #fff;
  }
  </style>
  