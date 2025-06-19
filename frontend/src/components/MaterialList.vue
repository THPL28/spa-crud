<template>
  <div class="material-list-container">
    <h1>Lista de Materiais</h1>

    <button @click="openCreateModal" class="btn-create">➕ Novo Material</button>

    <p v-if="loading" class="loading-message">Carregando materiais...</p>
    <p v-else-if="error" class="error-message">{{ error }}</p>
    <p v-else-if="materials.length === 0" class="no-materials-message">Nenhum material cadastrado ainda. Crie um novo!</p>

    <div v-else class="materials-grid">
      <div v-for="material in materials" :key="material.id" class="material-card">
        <h3>{{ material.nome }}</h3>
        <p><strong>Marca:</strong> {{ material.marca }}</p>
        <p><strong>Valor:</strong> R$ {{ formatCurrency(material.valor) }}</p>
        <p class="description">{{ material.descricao }}</p>
        <div class="card-actions">
          <button @click="openEditModal(material)" class="btn-edit">✏️ Editar</button>
          <button @click="confirmDelete(material.id)" class="btn-delete">🗑️ Excluir</button>
        </div>
      </div>
    </div>

    <MaterialModal
      v-if="showModal"
      :material="currentMaterial"
      @salvar="handleSaveMaterial"
      @fechar="closeModal"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import MaterialModal from './MaterialModal.vue'; // Importa seu componente de modal

const materials = ref([]);
const loading = ref(true);
const error = ref(null);

const showModal = ref(false);
const currentMaterial = ref(null); // Para passar o material para edição no modal

// --- Funções de Carregamento e CRUD ---

const fetchMaterials = async () => {
  loading.value = true;
  error.value = null;
  try {
    const response = await axios.get('/api/materiais'); // CUIDADO COM ESTA URL! Certifique-se de que corresponde à sua rota!
    materials.value = response.data;
  } catch (err) {
    console.error("Erro ao carregar materiais:", err);
    error.value = "Não foi possível carregar os materiais. Tente novamente mais tarde.";
  } finally {
    loading.value = false;
  }
};

const handleSaveMaterial = async (materialData) => {
  try {
    if (materialData.id) {
      // Editar
      await axios.put(`/api/materiais/${materialData.id}`, materialData);
    } else {
      // Criar
      await axios.post('/api/materiais', materialData);
    }
    closeModal();
    await fetchMaterials(); // Recarrega a lista após salvar
  } catch (err) {
    console.error("Erro ao salvar material:", err);
    alert("Houve um erro ao salvar o material. Verifique o console.");
  }
};

const confirmDelete = async (id) => {
  if (confirm("Tem certeza que deseja excluir este material?")) {
    try {
      await axios.delete(`/api/materiais/${id}`);
      await fetchMaterials(); // Recarrega a lista após exclusão
      alert("Material excluído com sucesso!");
    } catch (err) {
      console.error("Erro ao excluir material:", err);
      alert("Houve um erro ao excluir o material. Verifique o console.");
    }
  }
};

// --- Funções do Modal ---

const openCreateModal = () => {
  currentMaterial.value = null; // Limpa para um novo formulário
  showModal.value = true;
};

const openEditModal = (material) => {
  currentMaterial.value = material; // Passa o material para edição
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  currentMaterial.value = null;
};

// --- Funções Auxiliares ---

const formatCurrency = (value) => {
  return parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

// --- Ciclo de Vida ---
onMounted(() => {
  fetchMaterials(); // Chama a função de carregamento ao montar o componente
});
</script>

<style scoped>
.material-list-container {
  max-width: 1200px;
  margin: 2rem auto;
  padding: 1.5rem;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(10px);
  color: #fff;
}

h1 {
  text-align: center;
  color: #1abc9c;
  margin-bottom: 2rem;
  font-size: 2.5rem;
}

.btn-create {
  display: block;
  width: 200px;
  margin: 0 auto 2rem auto;
  padding: 0.8rem 1.5rem;
  background: #2ecc71;
  color: white;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-size: 1.1rem;
  font-weight: bold;
  transition: background 0.3s ease;
}

.btn-create:hover {
  background: #27ae60;
}

.loading-message, .error-message, .no-materials-message {
  text-align: center;
  font-size: 1.2rem;
  margin-top: 2rem;
}

.error-message {
  color: #e74c3c;
}

.materials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 1.5rem;
}

.material-card {
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  padding: 1.5rem;
  border-radius: 15px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.material-card h3 {
  color: #1abc9c;
  margin-top: 0;
  margin-bottom: 0.8rem;
  font-size: 1.5rem;
}

.material-card p {
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
  line-height: 1.4;
}

.material-card p.description {
  font-style: italic;
  font-size: 0.9rem;
  color: #ccc;
  flex-grow: 1; /* Faz a descrição ocupar o espaço disponível */
}

.material-card strong {
  color: #eee;
}

.card-actions {
  display: flex;
  gap: 0.8rem;
  margin-top: 1rem;
}

.btn-edit, .btn-delete {
  padding: 0.6rem 1rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: bold;
  flex: 1;
  transition: background 0.3s ease;
}

.btn-edit {
  background: #3498db;
  color: white;
}

.btn-edit:hover {
  background: #2980b9;
}

.btn-delete {
  background: #e74c3c;
  color: white;
}

.btn-delete:hover {
  background: #c0392b;
}
</style>