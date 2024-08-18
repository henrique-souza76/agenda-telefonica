<template>
    <base-template>
        <v-card
            variant="outlined"
            height="81.5vh"
            elevation="10"
            style="
            border-color: teal;
            margin: 25px auto;
            overflow-y: scroll;
            max-width: 600px;
            "
        >

            <v-row style="display: flex; align-items: center">
                <v-col>
                    <v-card-title
                    style="
                    font-size: 25px;
                    "
                    >Contatos</v-card-title>
                </v-col>
                <v-spacer></v-spacer>
                <v-col>
                    <v-btn color="teal">NOVO CONTATO</v-btn>
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
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            size="default"
                            color="blue-darken-1"
                            @click="editcontact(item)"
                        >
                            mdi-eye
                        </v-icon>
                        <v-icon
                            class="mx-3"
                            size="default"
                            @click="editcontact(item)"
                        >
                            mdi-pencil
                        </v-icon>
                        <v-icon
                            size="default"
                            @click="SetupConfirmationModal(
                                () => DeleteContact(item),
                                'Confirma exclusão do contato?',
                                'Essa ação não pode ser desfeita!'
                            )"
                            color="red"
                        >
                            mdi-delete
                        </v-icon>
                    </template>

                    <template v-slot:loading>
                        <v-skeleton-loader type="table-row@6"></v-skeleton-loader>
                    </template>
                </v-data-table-virtual>
            </v-card-text>
        </v-card>
    </base-template>

    <alert
        :type="alert_type"
        :visible="alert_visible"
        :message="alert_message"
        @close="alert_visible = false"
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
export default {
    data() {
        return {
            local_contacts: this.contacts,
            refresh_data: false,
            search: '',
            headers: [
                { title: 'Nome', key: 'name', sortable: false, width: "75%", class: 'font-weight-bold' },
                { title: 'Ações', key: 'actions', sortable: false, width: "25%", align: "center" },
            ],

            confirmation_modal_visible: false,
            confirmation_modal_message: '',
            confirmation_modal_warning_message: '',

            confirmation_modal_action: () => {},

            alert_type: '',
            alert_visible: false,
            alert_message: '',
        }
    },
    props: ["contacts"],
    methods: {
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
