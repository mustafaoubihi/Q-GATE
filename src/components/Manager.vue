<template>
    <div>
      <h1>Manager</h1>
      <form @submit.prevent="updateQualityGate">
        <label for="description">Update Description:</label>
        <textarea v-model="description" required></textarea><br>
        <label for="image">Update Image:</label>
        <input type="file" @change="onFileChange"><br>
        <button type="submit">Update</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        description: '',
        image: null
      };
    },
    methods: {
      onFileChange(event) {
        this.image = event.target.files[0];
      },
      updateQualityGate() {
        console.log('Description:', this.description);
        if (this.image) {
          console.log('Image:', this.image.name);
        }
        alert('Quality Gate details updated');
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add any specific styles for this component here */
  </style>
  