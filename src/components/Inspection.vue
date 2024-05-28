<template>
      <Navbar/>
  <div>
    <div class="table-container">
      <table class="fancy-table">
      <thead>
        <tr>
          <th>Problem</th>
          <th>Zone</th>
          <th>Post</th>
          <th>Status</th>
          <th>Result</th>
          <th>OK</th>
          <th>NOK</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="checklist in checklists" :key="checklist.id">
          <td>{{ checklist.problem }}</td>
          <td>{{ checklist.zone }}</td>
          <td>{{ checklist.post }}</td>
          <td>
            <span :class="checklist.isChecked ? 'badge-verified' : 'badge-in-progress'">
              {{ checklist.isChecked ? 'Verified' : 'In Progress' }}
            </span>
          </td>
          <td>
            <span :class="checklist.result ? 'badge-verified' : 'badge-in-progress'">
              {{ checklist.result ? 'Ok' : 'Not ok' }}
            </span>
          </td>
          <td>
            <img :src="getImageUrl(checklist.valideImgUrl)" alt="Valid Image" class="image-thumbnail" />
          </td>
          <td>
            <img :src="getImageUrl(checklist.notValideImgUrl)" alt="Not Valid Image" class="image-thumbnail" />
          </td>
          <td><button @click="openModal(checklist)">Verify</button></td>
        </tr>
      </tbody>
    </table>
    </div>
    <modal v-if="showModal" @close="closeModal">
      <template v-slot:header>
        <h2>Edit Item</h2>
      </template>
      <template v-slot:body>
        <form @submit.prevent="handleEdit">
          <div class="image-section">
            <div class="image-container">
              <img :src="getImageUrl(selectedItem.valideImgUrl)"alt="Pic 1" />
              <button type="button" @click="()=>{data.result = true}">OK {{ data.result === true?'!':'' }}</button>
            </div>
            <div class="image-container">
              <img :src="getImageUrl(selectedItem.notValideImgUrl)" alt="Pic 2" />
              <button type="button" @click="()=>{data.result = false}">Not ok {{ data.result === false?'!':'' }}</button>
            </div>
          </div>
          <div class="input-group">
            <label for="motif">Motif</label>
            <textarea id="motif" v-model="data.motif" required class="areatxt" placeholder="Motif ..." rows="5"></textarea>
          </div>
          <div class="modal-footer">
            <button type="submit" >Save</button>
            <button @click="closeModal" class="secondaryBtn">Close</button>
          </div>
        </form>
      </template>
    </modal>
  </div>
</template>

<script setup>
import { ref,onMounted } from 'vue';
import Modal from './Modal.vue'; // Assuming you have a Modal component
import Navbar from '../components/Navbar.vue'
import axios from 'axios';

const selectedItem = ref(null);
const data = ref({
  'user_id':JSON.parse(localStorage.getItem('user'))?.user.id,
  result:null,
  motif:''
})
const showModal = ref(false);

const openModal = (item) => {
  selectedItem.value = { ...item };
  showModal.value = true;
};
const checklists = ref([]);

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

const handleEdit = async() => {
  // Save changes to the selected item
  try {
    const res =  await axios.put(`http://127.0.0.1:8000/api/checklists/${selectedItem.value.id}`,data.value);
    if (res.data) {
      fetchChecklists()
    }

  } catch (error) {
    console.error('There was an error fetching the checklists!', error);
  }
  closeModal();
};


</script>

<style scoped>

.table-container{
  padding: 100px;
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



.input-group {
  margin-bottom: 1rem;
}

.input-group label {
  display: block;
  margin-bottom: 0.5rem;
}

.input-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.image-section {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1rem;
  max-width: 100%;
}


.image-thumbnail {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 5px;
}
.image-container {
  text-align: center;
}

.image-container img {
  border:1px solid black;
  border-radius: 15px;
  width: 550px;
  height: 400px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 0.5rem;
}

.image-container button {
  display: block;
  width: 100%;
  padding: 0.5rem;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.image-container button:hover {
  background-color: #2980b9;
}
.modal-footer{
  display: flex;
  gap: 5px;
  width: 100%;
  align-items: end;
  justify-content: flex-end;
}
.secondaryBtn{
  background-color: white ;
  color: black;
  border: #171717 solid 1px;
}

.secondaryBtn:hover{
  background-color: rgb(235, 235, 235) ;
}
.areatxt{
  max-width: 100%;
  width: 100%;
  border-radius: 8px;
  padding: 8px;
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
