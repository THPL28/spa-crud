
import './bootstrap';

import { createApp } from 'vue';
import MaterialList from './components/MaterialList.vue';
import MaterialModal from './components/MaterialModal.vue';

const app = createApp({});

app.component('material-list', MaterialList);
app.component('material-modal', MaterialModal);

app.mount('#app');
