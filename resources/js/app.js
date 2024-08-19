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
import MenuItem from './components/reusable_components/MenuItem.vue';

const app = createApp();

//Vue Filters
app.config.globalProperties.$filters = {
    formatText(value) {
        if(!value) return '';

        const screenWidth = window.innerWidth;

        if(screenWidth < 500) {
            return value.length > 16 ? value.slice(0, 16) + '...' : value;
        } else {
            return value.length > 45 ? value.slice(0, 45) + '...' : value;
        }
    }
};

//Components will be registered here
app.component('phonebook', Phonebook);
app.component('login', Login);

//Reusable Components
app.component('alert', Alert);
app.component('confirmation-modal', ConfirmationModal);
app.component('menu-item', MenuItem);

//Base Template
app.component('base-template', Template);

const vuetify = createVuetify({
    components,
    directives
})

app.use(vuetify).use(VueTheMask).mount('#app');
