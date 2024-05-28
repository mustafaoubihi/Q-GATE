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
          <th>Nb def</th>
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
          <td class="td-text">
            <div class="messageContainer">
              <div @click="showMessage(parseInt(checklist.nbProblems),checklist.id)" :class="getClass(checklist.nbProblems)" class="nbHolder">
                {{ checklist.nbProblems }}
              </div>
              <template v-if="message && checklist.id === activeId" >
                <div class="dropdown" @click="closeIt()" :class="getClass(checklist.nbProblems)">
                  {{ message }}
                </div>
              </template>
            </div>
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
const message = ref(null);

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
const activeId = ref(null)
function showMessage(nbProblems,id) {
  activeId.value = id
  if (nbProblems >= 1 && nbProblems <= 3) {
    message.value = "aviser contremaitre et auditeur";
  } else if (nbProblems > 3 && nbProblems < 5) {
    message.value = "aviser chef de shift et superviseur qualité";
  } else if (nbProblems >= 5) {
    message.value = "arrêter le poste";
  } else {
    message.value = null; // No message for other cases
  }
  console.log(message.value);
}
const closeIt = ()=>{
  activeId.value = null
  console.log(activeId.value );
}
function getClass(nbProblems) {
  if (nbProblems >= 1 && nbProblems < 3) {
    return 'yellow';
  } else if (nbProblems >= 3 && nbProblems < 5) {
    return 'orange';
  } else if (nbProblems >= 5) {
    return 'red';
  } else if (nbProblems === 0) {
    return 'green';
  }
  return '';
}

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

.problem-cell {
  position: relative;
  cursor: pointer;
}

.dropdown {
  position: absolute;
  min-width: 220px;
  top: 100%;
  left: -30px;
  z-index: 10;
  background-color: white;
  border: 1px solid #ccc;
  padding: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  margin-top: 5px;
  cursor: pointer;
}
.yellow {
  background-color: yellow;
}

.orange {
  background-color: orange;
}

.red {
  background-color: red;
  color: white;
}

.green {
  background-color: green;
}
.messageContainer{
  position: absolute;
  top: 30%;
}
.nbHolder{
  padding:8px 20px;
  cursor: pointer;
  border-radius: 10px;
}
.td-text{
  position: relative;
}
</style>
