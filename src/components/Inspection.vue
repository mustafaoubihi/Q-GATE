<template>
      <Navbar/>
  <div>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Pic 1</th>
            <th>Pic 2</th>
            <th>Zone</th>
            <th>Info 1</th>
            <th>Info 2</th>
            <th>etat</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in items" :key="index">
            <td>{{ index + 1 }}</td>
            <td><img :src="`src/assets/pics/${item.pic1}`" alt="Pic 1" /></td>
            <td><img :src="`src/assets/pics/${item.pic2}`" alt="Pic 2" /></td>
            <td>{{ item.zone }}</td>
            <td>{{ item.info1 }}</td>
            <td>{{ item.info2 }}</td>
            <td>{{ item.info2 }}</td>
            <td><button @click="openModal(item)">Edit</button></td>
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
              <img :src="`src/assets/pics/${selectedItem.pic1}`" alt="Pic 1" />
              <button type="button">OK</button>
            </div>
            <div class="image-container">
              <img :src="`src/assets/pics/${selectedItem.pic2}`" alt="Pic 2" />
              <button type="button">Not ok</button>
            </div>
          </div>
          <div class="input-group">
            <label for="motif">Motif</label>
            <textarea id="motif" v-model="selectedItem.motif" required class="areatxt" placeholder="Motif ..." rows="5"></textarea>
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
import { ref } from 'vue';
import Modal from './Modal.vue'; // Assuming you have a Modal component
import Navbar from '../components/Navbar.vue'

const selectedItem = ref(null);

const items = ref([
  {
    pic1: 'cart1.jpg',
    pic2: 'cart1.jpg',
    zone: 'Zone 1',
    info1: 'Information 1',
    info2: 'Information 2',
  },
  {
    pic1: 'cart1.jpg',
    pic2: 'cart1.jpg',
    zone: 'Zone 1',
    info1: 'Information 1',
    info2: 'Information 2',
  },
  {
    pic1: 'cart1.jpg',
    pic2: 'cart1.jpg',
    zone: 'Zone 1',
    info1: 'Information 1',
    info2: 'Information 2',
  },
  {
    pic1: 'cart1.jpg',
    pic2: 'cart1.jpg',
    zone: 'Zone 1',
    info1: 'Information 1',
    info2: 'Information 2',
  },
  // Add more items as needed
]);

const showModal = ref(false);

const openModal = (item) => {
  selectedItem.value = { ...item };
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
};

const handleEdit = () => {
  // Save changes to the selected item
  closeModal();
};
</script>

<style scoped>


.table-container {
  margin: 2rem;

}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 0.5rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f4f4f4;
}

td img {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 5px;
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

.image-container {
  text-align: center;
}

.image-container img {
  width: 350px;
  height: 300px;
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
</style>
