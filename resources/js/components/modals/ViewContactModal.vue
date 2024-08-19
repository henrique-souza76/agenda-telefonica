<template>
    <v-dialog
        v-model="local_visible"
        persistent :overlay="false" scrollable
        max-width="600px"
        min-width="300px"
        transition="dialog-transition"
    >
        <v-card>

            <v-card-title>Visualizar Contato</v-card-title>

            <v-card-text class="pt-0">
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
                        >
                            <v-img v-if="contact.image" :src="contact.image" ></v-img>
                            <v-icon v-else size="135">mdi-account-circle</v-icon>
                        </v-avatar>
                    </div>
                </v-container>

                <v-spacer style="height: 30px;"></v-spacer>

                <v-text-field
                    label="Nome"
                    v-model="contact.name"
                    prepend-icon="mdi-account"
                    readonly
                    variant="solo-filled"
                ></v-text-field>

                <v-spacer style="height: 10px;"></v-spacer>

                <v-text-field
                    label="Número de Telefone"
                    v-model="contact.phone"
                    prepend-icon="mdi-phone"
                    readonly
                    variant="solo-filled"
                ></v-text-field>

                <v-spacer style="height: 10px;"></v-spacer>

                <v-text-field
                    label="E-mail"
                    v-model="contact.email"
                    prepend-icon="mdi-at"
                    readonly
                    variant="solo-filled"
                ></v-text-field>

                <v-spacer style="height: 10px;"></v-spacer>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" @click="this.$emit('close')">Fechar</v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['visible', 'contact'],
    emits: ['close'],
    computed: {
        local_visible: {
            get() {
                return this.visible
            }
        }
    }
}
</script>
