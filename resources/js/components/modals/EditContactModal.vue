<template>
    <v-dialog
        v-model="local_visible"
        persistent :overlay="false" scrollable
        max-width="500px"
        transition="dialog-transition"
    >
        <v-card :loading="loading">

            <alert
                :type="alert_type"
                :visible="alert_visible"
                :message="alert_message"
                @close="alert_visible = false"
            />

            <v-card-title>Editar Contato</v-card-title>

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
                                <v-img v-if="contact.image" :src="contact.image" ></v-img>
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
                                :color="contact.image? 'teal' : 'black'"
                                :prepend-icon="contact.image? 'mdi-pencil' : ''"
                                @click="$refs.fileInput.click()"
                            >
                                {{ contact.image ? 'Trocar' : 'Adicionar imagem' }}
                            </v-btn>
                            <span
                                v-if="!contact.image"
                                style="font-size: 10px; color: red;"
                            >(max. 2MB)</span>
                            <span v-else>
                                <v-btn
                                    variant="text"
                                    color="red"
                                    prepend-icon="mdi-delete"
                                    @click="contact.image = null"
                                >Remover</v-btn>
                            </span>
                        </div>
                    </v-container>

                    <v-spacer style="height: 10px;"></v-spacer>

                    <v-text-field
                        label="Nome"
                        placeholder=""
                        persistent-placeholder
                        v-model="contact.name"
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
                        v-model="contact.phone"
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
                        v-model="contact.email"
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

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="blue-darken-1"
                            @click="() => {
                                this.contact.image = this.current_image;
                                this.$emit('close');
                            }"
                        >Cancelar</v-btn>
                        <v-btn color="teal" variant="elevated" class="px-5" @click="EditContact">Atualizar</v-btn>
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
            current_image: this.contact.image,

            loading: false,

            alert_type: '',
            alert_visible: false,
            alert_message: '',
        }
    },
    props: ['visible', 'contact'],
    emits: ['close', 'success'],
    computed: {
        local_visible: {
            get() {
                return this.visible
            }
        }
    },
    methods: {
        EditContact() {
            this.$refs.form.validate().then(response => {
                if(!response.valid) return;

                this.loading = 'teal';

                axios.put('/contato/editar', {
                    id: this.contact.id,
                    name: this.contact.name,
                    phone: this.contact.phone,
                    email: this.contact.email,
                    image: this.contact.image
                })
                .then(() => {
                    this.loading = false;
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
                            this.contact.image = e.target.result;
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
