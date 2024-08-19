<template>
    <v-dialog
        v-model="local_visible"
        persistent :overlay="false" scrollable
        max-width="600px"
        min-width="300px"
        transition="dialog-transition"
    >
        <v-card :loading="loading">

            <alert
                :type="alert_type"
                :visible="alert_visible"
                :message="alert_message"
                @close="alert_visible = false"
            />

            <v-card-title>Adicionar Contato</v-card-title>

            <v-card-text class="pt-0">
                <v-form
                    validate-on="lazy invalid-input"
                    @submit.prevent
                    ref="form"
                >

                    <v-container
                        class="pa-0"
                        style="margin: 0 auto;"
                        max-width="400px"
                    >
                        <div
                            class="d-block"
                            style="margin: 0 auto;
                            width: max-content;
                            "
                        >
                            <v-avatar
                                size="120"
                                color="teal"
                                variant="elevated"
                                style="cursor: pointer"
                                class="avatar-click"
                                @click="$refs.fileInput.click()"
                            >
                                <v-img v-if="image" :src="image" ></v-img>
                                <v-icon v-else size="40">mdi-image-plus</v-icon>
                            </v-avatar>
                            <input
                                ref="fileInput"
                                type="file"
                                accept="image/*"
                                style="display: none"
                                @change="ShowAddedImage"
                            />
                        </div>
                        <div style="text-align: center; margin: 5px 0;">
                            <v-btn
                                variant="text"
                                :color="image? 'teal' : 'black'"
                                :prepend-icon="image? 'mdi-pencil' : ''"
                                @click="$refs.fileInput.click()"
                            >
                                {{ image ? 'Trocar' : 'Adicionar imagem' }}
                            </v-btn>
                            <span
                                v-if="!image"
                                style="font-size: 10px; color: red; display: inline-block;"
                            >(max. 2MB)</span>
                            <span v-else>
                                <v-btn
                                    variant="text"
                                    color="red"
                                    prepend-icon="mdi-delete"
                                    @click="image = null"
                                >Remover</v-btn>
                            </span>
                        </div>
                    </v-container>

                    <v-spacer style="height: 10px;"></v-spacer>

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
                        :rules="[
                            (v) => !!v || 'Este campo é obrigatório!',
                            (v) => /\(\d{2}\) \d{5}-\d{4}/.test(v) || 'Número de telefone inválido'
                        ]"
                    ></v-text-field>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-text-field
                        label="E-mail"
                        placeholder=""
                        persistent-placeholder
                        v-model="email"
                        type="email"
                        variant="outlined"
                        color="teal"
                        density="comfortable"
                        :rules="[
                            (v) => !!v || 'Este campo é obrigatório!',
                            (v) => /.+@.+\..+/.test(v) || 'E-mail inválido!'
                        ]"
                    ></v-text-field>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-card-actions class="pa-0 d-flex justify-end" style="min-width: 237px;">
                        <v-btn color="blue-darken-1" @click="this.$emit('close')">Cancelar</v-btn>
                        <v-btn color="teal" variant="elevated" class="px-5" @click="AddContact">Adicionar</v-btn>
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
            image: null,
            name: '',
            phone_number: '',
            email: '',

            loading: false,

            alert_type: '',
            alert_visible: false,
            alert_message: '',
        }
    },
    props: ['visible'],
    emits: ['close', 'success'],
    computed: {
        local_visible: {
            get() {
                return this.visible
            }
        }
    },
    methods: {
        AddContact() {
            this.$refs.form.validate().then(response => {
                if(!response.valid) return;

                this.loading = 'teal';

                axios.post('/contato/adicionar', {
                    name: this.name,
                    phone: this.phone_number,
                    email: this.email,
                    image: this.image
                })
                .then(() => {
                    this.loading = false;
                    this.ResetContactData();
                    this.$emit('close');
                    this.$emit('success');
                })
                .catch(error => {
                    this.loading = false;
                    this.SetupAlert("error", error.response.data.message);
                    //console.log(error.response);
                });

            });
        },
        ShowAddedImage(event) {
            const file = event.target.files[0];
            const maxSizeInBytes = 2 * 1024 * 1024;

            if(file) {
                if(file.type.startsWith('image/')) {
                    if(file.size > maxSizeInBytes) {
                        this.SetupAlert('error', 'Tamanho máximo permitido é 2MB!');
                    } else {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.image = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                } else {
                    this.SetupAlert('error', 'O arquivo não é uma imagem!');
                }
            }
        },
        SetupAlert(type, message) {
            this.alert_type = type;
            this.alert_message = message;
            this.alert_visible = true;
        },
        ResetContactData() {
            this.image = null;
            this.name = '';
            this.phone_number = '';
            this.email = '';
        }
    }
}
</script>
<style scoped>
.avatar-click:active {
    filter: brightness(1.1);
    transform: scale(0.97);
}
</style>
