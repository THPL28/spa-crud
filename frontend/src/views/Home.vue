<template>
  <div class="page">
    <div class="content-card">
      <header>
        <h1>Materiais de Construção</h1>
        <button class="btn-primary" @click="abrirModalNovo">+ Novo Material</button>
      </header>

      <p v-if="loading" style="text-align: center; margin-top: 20px; color: #1abc9c;">Carregando materiais...</p>
      <p v-else-if="materiais.length === 0" style="text-align: center; margin-top: 20px; color: #ccc;">Nenhum material cadastrado ainda. Adicione um novo!</p>

      <table v-else>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Marca</th>
            <th>Valor (R$)</th>
            <th>Descrição</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="material in materiais" :key="material.id">
            <td>{{ material.nome }}</td>
            <td>{{ material.marca }}</td>
            <td>R$ {{ formatarValor(material.valor) }}</td>
            <td>{{ material.descricao }}</td>
            <td>{{ formatarData(material.created_at) }}</td>
            <td class="actions">
              <button class="btn-icon view" @click="visualizar(material)">👁️</button>
              <button class="btn-icon edit" @click="editar(material)">✏️</button>
              <button class="btn-icon delete" @click="excluir(material.id)">🗑️</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <transition name="fade-scale">
      <MaterialModal
        v-if="mostrarModal"
        :material="materialAtual"
        @salvar="salvarMaterial"
        @fechar="fecharModal"
      />
    </transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import MaterialModal from '../components/MaterialModal.vue'

const materiais = ref([])
const mostrarModal = ref(false)
const materialAtual = ref(null)
const loading = ref(false)

const carregarMateriais = async () => {
  loading.value = true
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/materiais')
    materiais.value = res.data
  } catch (error) {
    console.error("Erro ao carregar materiais:", error)
  } finally {
    loading.value = false
  }
}

const abrirModalNovo = () => {
  materialAtual.value = null
  mostrarModal.value = true
}

const formatarValor = (valor) => {
  return parseFloat(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
}

const formatarData = (dataString) => {
  return new Date(dataString).toLocaleString('pt-BR')
}

const visualizar = (material) => {
  alert(`
Nome: ${material.nome}
Marca: ${material.marca}
Valor: R$ ${formatarValor(material.valor)}
Descrição: ${material.descricao}
Data: ${formatarData(material.created_at)}
  `)
}

const editar = (material) => {
  materialAtual.value = { ...material }
  mostrarModal.value = true
}

const excluir = async (id) => {
  if (confirm('Tem certeza que deseja excluir este material?')) {
    try {
      await axios.delete(`http://127.0.0.1:8000/api/materiais/${id}`)
      await carregarMateriais()
      alert('Material excluído com sucesso!')
    } catch (error) {
      console.error("Erro ao excluir material:", error)
      alert("Houve um erro ao excluir o material.")
    }
  }
}

const salvarMaterial = async (material) => {
  try {
    if (material.id) {
      await axios.put(`http://127.0.0.1:8000/api/materiais/${material.id}`, material)
    } else {
      await axios.post(`http://127.0.0.1:8000/api/materiais`, material)
    }
    await carregarMateriais()
    mostrarModal.value = false
    alert('Material salvo com sucesso!')
  } catch (error) {
    console.error("Erro ao salvar material:", error)
    alert("Houve um erro ao salvar o material. Verifique o console.")
  }
}

const fecharModal = () => {
  mostrarModal.value = false
}

onMounted(carregarMateriais)
</script>

<style scoped>
.page {
  min-height: 100vh;
  width: 100vw;
  background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 2rem;
  font-family: 'Segoe UI', sans-serif;
  margin: 0;
}

.content-card {
  width: 100%;
  max-width: 1000px;
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 2rem;
  border-radius: 20px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
  color: #fff;
  animation: fadeIn 0.8s ease;
}

header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

h1 {
  font-size: 2.5rem;
  font-weight: bold;
}

.btn-primary {
  background: #1abc9c;
  color: white;
  border: none;
  padding: 0.6rem 1.3rem;
  font-size: 1rem;
  border-radius: 10px;
  cursor: pointer;
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
  transition: background 0.3s ease;
}

.btn-primary:hover {
  background: #16a085;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
  background-color: rgba(255, 255, 255, 0.05);
  border-radius: 12px;
  overflow: hidden;
}

thead tr {
  background-color: rgba(255, 255, 255, 0.1);
}

th, td {
  padding: 0.9rem;
  text-align: left;
  color: #f1f1f1;
}

tbody tr:hover {
  background-color: rgba(255, 255, 255, 0.07);
}

.actions {
  display: flex;
  gap: 0.5rem;
}

.btn-icon {
  background: transparent;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  transition: transform 0.2s;
}

.btn-icon:hover {
  transform: scale(1.2);
}

.btn-icon.view:hover {
  color: #3498db;
}

.btn-icon.edit:hover {
  color: #f1c40f;
}

.btn-icon.delete:hover {
  color: #e74c3c;
}

/* Animations */
@keyframes fadeIn {
  0% {
    opacity: 0;
    transform: translateY(15px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.fade-scale-enter-active,
.fade-scale-leave-active {
  transition: all 0.3s ease;
}

.fade-scale-enter-from,
.fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.9);
}
</style>