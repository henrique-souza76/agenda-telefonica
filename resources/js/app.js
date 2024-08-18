import './bootstrap';
import { createApp } from 'vue';
import VueTheMask from 'vue-the-mask';

//Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css';

//Components will be imported here
import Phonebook from './components/Phonebook.vue';
import Login from './components/Login.vue';
import Alert from './components/reusable_components/Alert.vue';
import ConfirmationModal from './components/modals/ConfirmationModal.vue';
import Template from './components/Template.vue';

const app = createApp();

//Components will be registered here
app.component('phonebook', Phonebook);
app.component('login', Login);

//Reusable Components
app.component('alert', Alert);
app.component('confirmation-modal', ConfirmationModal);

//Base Template
app.component('base-template', Template);

const vuetify = createVuetify({
    components,
    directives
})

app.use(vuetify).use(VueTheMask).mount('#app');
