<template>
  <div class="modal" @click.self="$emit('fechar')">
    <div class="modal-content">
      <h2>{{ material?.id ? 'Editar Material' : 'Novo Material' }}</h2>

      <form @submit.prevent="emitirSalvar">
        <label>Nome
          <input v-model="dados.nome" required placeholder="Ex: Cimento CP II" />
        </label>

        <label>Marca
          <input v-model="dados.marca" required placeholder="Ex: Votoran" />
        </label>

        <label>Valor (R$)
          <input v-model.number="dados.valor" required type="number" min="0" step="0.01" />
        </label>

        <label>Descrição
          <textarea v-model="dados.descricao" rows="3" required placeholder="Descrição detalhada..."></textarea>
        </label>

        <div class="buttons">
          <button type="submit" class="btn-save">💾 Salvar</button>
          <button type="button" class="btn-cancel" @click="$emit('fechar')">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({ material: Object })
const emit = defineEmits(['salvar', 'fechar'])

const dados = reactive({
  id: null,
  nome: '',
  marca: '',
  valor: '',
  descricao: ''
})

watch(() => props.material, (val) => {
  if (val) Object.assign(dados, val)
  else Object.assign(dados, { id: null, nome: '', marca: '', valor: '', descricao: '' })
}, { immediate: true })

const emitirSalvar = () => {
  emit('salvar', { ...dados })
}
</script>

<style scoped>
.modal {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(6px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  width: 100%;
  max-width: 500px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 2rem;
  border-radius: 20px;
  color: #fff;
  box-shadow: 0 12px 30px rgba(0,0,0,0.4);
  animation: scaleFadeIn 0.3s ease;
  backdrop-filter: blur(20px);
}

h2 {
  font-size: 1.8rem;
  margin-bottom: 1.5rem;
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

label {
  display: flex;
  flex-direction: column;
  font-weight: 600;
  font-size: 0.95rem;
}

input, textarea {
  margin-top: 0.4rem;
  padding: 0.6rem;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 1rem;
  background: rgba(255, 255, 255, 0.1);
  color: #fff;
  outline: none;
  transition: border 0.3s ease;
}

input:focus, textarea:focus {
  border-color: #1abc9c;
  background: rgba(255, 255, 255, 0.15);
}

.buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 1.5rem;
  gap: 1rem;
}

.btn-save {
  background: #1abc9c;
  color: white;
  border: none;
  padding: 0.6rem 1.5rem;
  border-radius: 10px;
  cursor: pointer;
  font-size: 1rem;
  font-weight: bold;
  flex: 1;
  transition: background 0.3s ease;
}

.btn-save:hover {
  background: #16a085;
}

.btn-cancel {
  background: transparent;
  color: #eee;
  border: 1px solid #aaa;
  padding: 0.6rem 1.5rem;
  border-radius: 10px;
  cursor: pointer;
  font-size: 1rem;
  flex: 1;
  transition: background 0.3s ease;
}

.btn-cancel:hover {
  background: rgba(255, 255, 255, 0.1);
}

@keyframes scaleFadeIn {
  from {
    opacity: 0;
    transform: scale(0.92);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}
</style>
