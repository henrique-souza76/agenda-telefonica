<template>

    <alert
        :type="alert_type"
        :visible="alert_visible"
        :message="alert_message"
        @close="alert_visible = false"
    />

    <base-template>

        <v-card
            variant="outlined"
            max-height="81.5vh"
            elevation="10"
            style="
            border-color: teal;
            overflow-y: scroll;
            width: 600px;
            max-width: 600px;
            "
        >

            <v-row style="display: flex; align-items: center; flex-wrap: wrap;">
                <v-col>
                    <v-card-title
                    style="
                    font-size: 25px;
                    padding-bottom: 0;
                    "
                    >Contatos</v-card-title>
                </v-col>
                <v-spacer></v-spacer>
                <v-col
                    style="
                    margin-right: 15px;
                    display: flex;
                    justify-content: center;
                    min-width: 250px;
                    margin-top: 5px;
                ">
                    <v-btn color="teal" @click="AddContact" width="80%">NOVO CONTATO</v-btn>
                </v-col>
            </v-row>

            <v-card-text>
                <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    hide-details
                    single-line
                    label="Pesquisar"
                    variant="outlined"
                    color="teal"
                ></v-text-field>
            </v-card-text>

            <v-card-text>
                <v-data-table-virtual
                    :items="local_contacts"
                    :headers="headers"
                    :search="search"
                    :loading="refresh_data"
                    filter-keys="name"
                    class="elevation-1"
                    hover
                    no-data-text="Nenhum contato cadastrado"
                >

                    <template v-slot:item.name="{ item }" class="d-flex">
                        <v-avatar size="small" color="teal" class="mr-3">
                            <v-img
                            v-if="item.image"
                            :src="item.image"
                            cover
                            ></v-img>
                            <v-icon v-else size="45">mdi-account-circle</v-icon>
                        </v-avatar>
                        <span style="font-family: 'Roboto Mono', monospace;">{{ $filters.formatText(item.name) }}</span>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-menu location="center">
                            <template v-slot:activator="{ props }">
                                <v-btn variant="text" icon="mdi-dots-vertical" v-bind="props"></v-btn>
                            </template>
                            <v-list>
                                <menu-item
                                icon="eye"
                                text='Visualizar'
                                color="blue darken-1"
                                :action="() => ViewContact(item)"
                                />
                                <menu-item
                                icon="pencil"
                                text='Editar'
                                color="teal"
                                :action="() => EditContact(item)"
                                />
                                <menu-item
                                icon="delete"
                                text='Excluir'
                                color="red"
                                :action="() => SetupConfirmationModal(
                                    () => DeleteContact(item),
                                    'Confirma exclusão do contato?',
                                    'Essa ação não pode ser desfeita!'
                                )"
                                />
                            </v-list>
                        </v-menu>
                    </template>

                    <template v-slot:loading>
                        <v-skeleton-loader type="table-row@6"></v-skeleton-loader>
                    </template>
                </v-data-table-virtual>
            </v-card-text>
        </v-card>
    </base-template>

    <view-contact-modal
        :visible="view_contact_modal_visible"
        :contact="selected_contact"
        @close="view_contact_modal_visible = false"
    />

    <add-contact-modal
        :visible="add_contact_modal_visible"
        @close="add_contact_modal_visible = false"
        @success="() => {
            SetupAlert('success', 'Contato adicionado com sucesso!');
            RefreshContacts();
        }"
    />

    <edit-contact-modal
        :visible="edit_contact_modal_visible"
        :contact="selected_contact"
        @close="edit_contact_modal_visible = false"
        @success="() => {
            SetupAlert('success', 'Contato atualizado com sucesso!');
            RefreshContacts();
        }"
    />

    <confirmation-modal
        :visible="confirmation_modal_visible"
        :message="confirmation_modal_message"
        :warning_message="confirmation_modal_warning_message"
        @close="confirmation_modal_visible = false"
        @confirm="confirmation_modal_action"
    />
</template>
<script>
import ViewContactModal from './modals/ViewContactModal.vue';
import AddContactModal from './modals/AddContactModal.vue';
import EditContactModal from './modals/EditContactModal.vue';

export default {
    data() {
        return {
            local_contacts: this.contacts,
            refresh_data: false,
            search: '',
            headers: [
                { title: 'Nome', key: 'name', sortable: false, width: '90%', class: 'font-weight-bold' },
                { title: 'Ações', key: 'actions', sortable: false, width: '10%', align: "center" },
            ],

            view_contact_modal_visible: false,
            add_contact_modal_visible: false,
            edit_contact_modal_visible: false,

            selected_contact: {},

            confirmation_modal_visible: false,
            confirmation_modal_message: '',
            confirmation_modal_warning_message: '',

            confirmation_modal_action: () => {},

            alert_type: '',
            alert_visible: false,
            alert_message: '',
        }
    },
    components: {
        'view-contact-modal': ViewContactModal,
        'add-contact-modal': AddContactModal,
        'edit-contact-modal': EditContactModal,
    },
    props: ["contacts"],
    methods: {
        ViewContact(contact) {
            this.selected_contact = contact;
            this.view_contact_modal_visible = true;
        },
        AddContact() {
            this.add_contact_modal_visible = true;
        },
        EditContact(contact) {
            this.selected_contact = contact;
            this.edit_contact_modal_visible = true;
        },
        DeleteContact(contact) {
            axios.delete('/contato/deletar', {
                params: {
                    contact_id: contact.id
                }
            })
            .then(response => {
                this.SetupAlert("success", response.data.message);
                this.RefreshContacts();
            }).catch(error => {
                this.SetupAlert("error", error.response.data.message);
                //console.log(error.response.data);
            })

            this.ResetConfirmationModal();
        },
        SetupConfirmationModal(action, message, warningMessage = '') {
            this.confirmation_modal_message = message;
            this.confirmation_modal_warning_message = warningMessage;
            this.confirmation_modal_action = action;
            this.confirmation_modal_visible = true;
        },
        ResetConfirmationModal() {
            this.confirmation_modal_message = '';
            this.confirmation_modal_warning_message = '';
            this.confirmation_modal_action = () => {};
            this.confirmation_modal_visible = false;
        },
        SetupAlert(type, message) {
            this.alert_type = type;
            this.alert_message = message;
            this.alert_visible = true;
        },
        RefreshContacts() {
            this.refresh_data = true;

            axios.get('/contato/obterContatos')
            .then(response => {
                this.local_contacts = response.data.contacts;

                setTimeout(() => { this.refresh_data = false; }, 1000);
            })
        }
    }
}
</script>
