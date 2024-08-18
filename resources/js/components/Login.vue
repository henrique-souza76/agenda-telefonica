<template>
    <alert
        :type="alert_type"
        :visible="alert_visible"
        :message="alert_message"
        @close="alert_visible = false"
    />
    <v-container
        width="100%"
        height="100%"
        class="d-flex align-center justify-center"
    >
        <v-card
            width="80%"
            min-height="400px"
            max-width="500px"
            density="comfortable"
            elevation="10"
            :loading="loading"
            class="pa-4 pt-5"
            style="border-radius: 10px;"
        >
            <v-card-title
                style="
                text-align: center;
                font-weight: bold;
                font-size: 23px;
                "
            >Login</v-card-title>
            <v-card-text>
                <v-form
                    validate-on="lazy invalid-input"
                    @submit.prevent
                    @keydown.enter="Authenticate"
                    ref="form"
                >
                    <v-spacer style="margin-bottom: 10%;"></v-spacer>
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
                    <v-row>
                        <v-checkbox
                            label="Lembrar de mim"
                            v-model="remember_value"
                            color="teal">
                        </v-checkbox>
                    </v-row>
                    <v-spacer style="margin-bottom: 10%;"></v-spacer>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue-darken-1" @click="create_user_modal_visible = true">Novo usuário</v-btn>
                        <v-btn color="teal" variant="elevated" class="px-5" @click="Authenticate">Entrar</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
    <create-user-modal
        :visible="create_user_modal_visible"
        :numbers="numbers"
        @close="create_user_modal_visible = false"
        @success="() => {
            SetupAlert('success', 'Usuário cadastrado com sucesso!');
        }"
    />
</template>
<script>
import CreateUserModal from './modals/CreateUserModal.vue';

export default {
    data() {
        return {
            loading: false,
            phone_number: '',
            password: '',
            show_password: false,
            remember_value: false,

            alert_type: '',
            alert_visible: false,
            alert_message: '',

            create_user_modal_visible: false,
        }
    },
    components: {
        'create-user-modal': CreateUserModal
    },
    props: ['numbers'],
    methods: {
        Authenticate() {
            this.$refs.form.validate().then(response => {
                if(!response.valid) return;

                this.loading = 'teal';

                axios.post('/login/autenticar', {
                    phone: this.phone_number,
                    password: this.password,
                    remember_value: this.remember_value,
                })
                .then(response => {
                    window.location.replace(response.data.redirect);
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
