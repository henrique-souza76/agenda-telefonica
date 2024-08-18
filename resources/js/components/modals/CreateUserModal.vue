<template>
    <v-dialog
        v-model="local_visible"
        persistent :overlay="false" scrollable
        max-width="600px"
        transition="dialog-transition"
    >
        <v-card :loading="loading">

            <alert
                :type="alert_type"
                :visible="alert_visible"
                :message="alert_message"
                @close="alert_visible = false"
            />

            <v-card-title >Cadastrar novo usuário</v-card-title>

            <v-spacer style="height: 10px;"></v-spacer>

            <v-card-text>
                <v-form
                    validate-on="lazy invalid-input"
                    @submit.prevent
                    @keydown.enter=""
                    ref="form"
                >
                    <v-text-field
                        label="Nome"
                        placeholder=""
                        persistent-placeholder
                        v-model="name"
                        variant="outlined"
                        color="teal"
                        density="comfortable"
                        :rules="[(v) => !!v || 'Este campo é obrigatório!']"
                    ></v-text-field>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-text-field
                        label="Número de Telefone"
                        placeholder=""
                        persistent-placeholder
                        v-model="phone_number"
                        type="tel"
                        variant="outlined"
                        v-mask="'(##) #####-####'"
                        color="teal"
                        density="comfortable"
                        :rules="[(v) => !!v || 'Este campo é obrigatório!']"
                    ></v-text-field>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-text-field
                        label="Senha"
                        placeholder=""
                        persistent-placeholder
                        v-model="password"
                        :type="show_password? 'text' : 'password'"
                        variant="outlined"
                        color="teal"
                        density="comfortable"
                        :rules="[(v) => !!v || 'Este campo é obrigatório!']"
                        :append-inner-icon="show_password? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append-inner="show_password = !show_password"
                    ></v-text-field>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-text-field
                        label="Confirme a Senha"
                        placeholder=""
                        persistent-placeholder
                        v-model="password_confirmation"
                        :type="show_password? 'text' : 'password'"
                        variant="outlined"
                        color="teal"
                        density="comfortable"
                        :rules="[
                            (v) => !!v || 'Este campo é obrigatório!',
                            (v) => v == this.password || 'As senhas não coincidem!'
                        ]"
                        :append-inner-icon="show_password? 'mdi-eye-off' : 'mdi-eye'"
                        @click:append-inner="show_password = !show_password"
                    ></v-text-field>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue-darken-1" @click="this.$emit('close')">Cancelar</v-btn>
                        <v-btn color="teal" variant="elevated" class="px-5" @click="CreateUser">Cadastrar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    data() {
        return {
            name: '',
            phone_number: '',
            password: '',
            password_confirmation: '',
            show_password: false,
            loading: false,

            alert_type: '',
            alert_visible: false,
            alert_message: '',
        }
    },
    props: ['visible'],
    emits: ['close'],
    computed: {
        local_visible: {
            get() {
                return this.visible;
            }
        }
    },
    methods: {
        CreateUser() {
            this.$refs.form.validate().then(response => {
                if(!response.valid) return;

                this.loading = 'teal';

                axios.post('/usuario/criar', {
                    name: this.name,
                    phone: this.phone_number,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                })
                .then(response => {
                    this.loading = false;
                    this.SetupAlert("success", response.data.message);
                    this.$emit('close');
                })
                .catch(error => {
                    this.loading = false;
                    this.SetupAlert("error", error.response.data.message);
                    //console.log(error.response);
                });

            });
        },
        SetupAlert(type, message) {
            this.alert_type = type;
            this.alert_message = message;
            this.alert_visible = true;
        },
    }
}
</script>
