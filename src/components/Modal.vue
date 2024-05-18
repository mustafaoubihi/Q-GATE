<template>
    <div class="modal-backdrop" @click.self="close">
      <div class="modal">
        <header>
          <slot name="header"></slot>
        </header>
        <main>
          <slot name="body"></slot>
        </main>
        <footer>
          <button @click="close">Close</button>
        </footer>
      </div>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({
    show: Boolean
  });
  
  const emits = defineEmits(['close']);
  
  const close = () => {
    emits('close');
  };
  </script>
  
  <style scoped>
  .modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .modal {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 400px;
    max-width: 100%;
  }
  
  header {
    margin-bottom: 1rem;
  }
  
  footer {
    margin-top: 1rem;
    text-align: right;
  }
  
  button {
    padding: 0.5rem 1rem;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  
  button:hover {
    background-color: #2980b9;
  }
  </style>
  