<template>
  <div class="container">
    <Navbar/>
    <div class="table-container">
      <div class="page-head">
        <h2>Checklist Table</h2>
        <button @click="showModal = true">Add New Item</button>
      </div>
    <table class="fancy-table">
      <thead>
        <tr>
          <th>Problem</th>
          <th>Zone</th>
          <th>Post</th>
          <th>Number of Problems</th>
          <th>Status</th>
          <th>result</th>
          <th>Valid Image</th>
          <th>Not Valid Image</th>
          <th>Verified by</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="checklist in checklists" :key="checklist.id">
          <td>{{ checklist.problem }}</td>
          <td>{{ checklist.zone }}</td>
          <td>{{ checklist.post }}</td>
          <td>{{ checklist.nbProblems }}</td>
          <td>
            <span :class="checklist.isChecked ? 'badge-verified' : 'badge-in-progress'">
              {{ checklist.isChecked ? 'Verified' : 'In Progress' }}
            </span>
          </td>
          <td>
            <span :class="checklist.result ? 'badge-verified' : 'badge-in-progress'">
              {{ checklist.result ?? '_' }}
            </span>
          </td>
          <td>
            <img :src="getImageUrl(checklist.valideImgUrl)" alt="Valid Image" class="image-thumbnail" />
          </td>
          <td>
            <img :src="getImageUrl(checklist.notValideImgUrl)" alt="Not Valid Image" class="image-thumbnail" />
          </td>
          <td>{{ checklist.user?  checklist?.user?.lastName + ' '+ checklist?.user?.firstName : '_' }}</td>

        </tr>
      </tbody>
    </table>
  </div>

    <modal v-if="showModal" @close="closeModal">
    <template v-slot:header>
      <h2>Add New Item</h2>
    </template>
    <template v-slot:body>
      <form @submit.prevent="submitForm">
      <div class="form-group">
        <label for="problem">Problem:</label>
        <input id="problem" v-model="checkList.problem" required />
      </div>
      
      <div class="form-group">
        <label for="zone">Zone:</label>
        <input id="zone" v-model="checkList.zone" required />
      </div>
      
      <div class="form-group">
        <label for="post">Post:</label>
        <input id="post" v-model="checkList.post" required />
      </div>
      
      <div class="form-group">
        <label for="nbProblems">Number of Problems:</label>
        <input id="nbProblems" v-model="checkList.nbProblems" type="number" required />
      </div>
      
      <div class="form-group">
        <label for="valideImgUrl">Valid Image:</label>
        <input id="valideImgUrl" type="file" @change="handleFileUpload('valideImgUrl', $event)" required />
      </div>
      
      <div class="form-group">
        <label for="notValideImgUrl">Not Valid Image:</label>
        <input id="notValideImgUrl" type="file" @change="handleFileUpload('notValideImgUrl', $event)" required />
      </div>
      
      <button type="submit" class="submit-button">Add Checklist</button>
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

const checklists = ref([]);

const checkList = ref({
  problem: '',
  zone: '',
  post: '',
  nbProblems: 0,
  valideImgUrl: null,
  notValideImgUrl: null,
});

const handleFileUpload = (field, event) => {
  checkList.value[field] = event.target.files[0];
};

const showModal = ref(false);

const fetchChecklists = async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/checklists');
    checklists.value = response.data;
  } catch (error) {
    console.error('There was an error fetching the checklists!', error);
  }
};

onMounted(fetchChecklists);

const closeModal = () => {
  showModal.value = false;
};
const getImageUrl = (path) => {
  return `http://127.0.0.1:8000/storage/${path}`;
};

const submitForm = async () => {
  const formData = new FormData();
  formData.append('problem', checkList.value.problem);
  formData.append('zone', checkList.value.zone);
  formData.append('post', checkList.value.post);
  formData.append('nbProblems', checkList.value.nbProblems);
  formData.append('valideImgUrl', checkList.value.valideImgUrl);
  formData.append('notValideImgUrl', checkList.value.notValideImgUrl);

  try {
    const response = await axios.post('http://127.0.0.1:8000/api/checklists', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    });
    console.log('Checklist added', response.data);
    // Reset form after submission
    Object.keys(checkList.value).forEach(key => {
      checkList.value[key] = key.includes('ImgUrl') ? null : '';
    });
    fetchChecklists()
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
