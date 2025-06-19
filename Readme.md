# 🏗️ CRUD de Materiais de Construção

Este projeto foi desenvolvido como parte de um **desafio técnico para a vaga de Desenvolvedor Pleno**. A aplicação consiste em um sistema **SPA (Single Page Application)** para gerenciar materiais de construção, utilizando **Vue.js 3 + Vite no frontend** e **Laravel 10 no backend**, com visual moderno e responsivo.

---

## 🎨 Design da Interface

A interface foi desenvolvida com foco em **design visual moderno** e UX, incluindo:

- Fundo com **degradê elegante**
- Container com **efeito vidro (glassmorphism)**, sombra e bordas arredondadas
- Tipografia clara e elegante
- Botões com efeitos de hover e sombra
- Modal com **animação suave (fade + scale)**
- Layout limpo e responsivo, ideal para testes técnicos e apresentações

---

## 🚀 Tecnologias Utilizadas

### ⚙️ Backend

- [Laravel  9.52.20](https://laravel.com/)
- API RESTful para operações CRUD
- Banco de dados: SQLite (ou MySQL/PostgreSQL)
- CORS configurado com Fruitcake
- Roteamento via `routes/api.php`
- Migrations e Eloquent ORM

### 🎨 Frontend

- [Vue.js 3](https://vuejs.org/)
- [Vite](https://vitejs.dev/)
- Axios para comunicação com API
- Estilização manual (CSS) com animações e transições
- Sem bibliotecas de UI externas

---

## 📂 Estrutura de Pastas

spa-crud/
├── backend/ ← API Laravel
└── frontend/ ← SPA Vue.js 3 com Vite



---

## 📸 Capturas de Tela

### Tela Principal

![home](screens/home.png)

### Modal de Cadastro / Edição

![modal](screens/modal.png)

---

## ✅ Funcionalidades

- 🔹 Criar material de construção
- 🔹 Listar todos os materiais
- 🔹 Editar dados dos materiais
- 🔹 Visualizar detalhes em alerta
- 🔹 Excluir material
- 🔹 Modal com animação e efeito vidro
- 🔹 Interface moderna e responsiva


## 📦 Instalação do Projeto

### 1️ Backend - Laravel (API)


```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

A API estará disponível em: http://127.0.0.1:8000/api/materiais
````

### 2️ Frontend - Vue.js + Vite

```bash
cd ../frontend
npm install
npm run dev

A aplicação estará acessível em: http://localhost:5173

````
### 📝 Detalhes Visuais e Estéticos
````
Home.vue
Fundo com linear-gradient

Card com blur + shadow

Botões com hover, animação e ícones

Tabela estilizada com hover nas linhas

Animações com @keyframes fadeIn, transition: scale

MaterialModal.vue
Modal centralizado com glassmorphism

Inputs e textarea com visual limpo

Botões com cores contrastantes e hover

Transição de abertura suave

### 📬 Contato
Desenvolvido por: Tiago Looze
🔗 LinkedIn
🐙 GitHub
📧 Email: thpldevweb@gmail.com

