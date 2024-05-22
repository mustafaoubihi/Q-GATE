<template>
  <div class="modal-overlay" @click.self="close">
    <div class="modal-container">
      <button class="modal-close" @click="close">×</button>
      <div class="modal-content">
        <slot name="header"></slot>
        <slot name="body"></slot>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  show: Boolean,
});

const emit = defineEmits(['close']);

const close = () => {
  emit('close');
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  transition: opacity 0.3s ease;
}

.modal-container {
  background: white;
  padding: 30px;
  border-radius: 10px;
  width: 500px;
  max-width: 90%;
  position: relative;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  animation: slide-down 0.3s ease;
}

.modal-close {
  position: absolute;
  top: 15px;
  right: 15px;
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #333;
  transition: color 0.3s ease;
}

.modal-close:hover {
  color: #f44336;
}

.modal-content {
  padding: 20px;
}

.modal-content h2 {
  margin-top: 0;
  margin-bottom: 20px;
  font-size: 1.8rem;
  color: #333;
}

@keyframes slide-down {
  from {
    transform: translateY(-20%);
  }
  to {
    transform: translateY(0);
  }
}
</style>
