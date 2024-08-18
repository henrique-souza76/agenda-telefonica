<template>
    <v-dialog
        v-model="local_visible"
        persistent :overlay="false"
        max-width="450px"
        transition="dialog-transition"
    >
        <v-card>
            <v-card-text>
                {{ message }}
            </v-card-text>
            <v-card-text v-if="warning_message" style="color: red;">
                {{ "ATENÇÃO: " + warning_message }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" @click="this.$emit('close')">Cancelar</v-btn>
                <v-btn color="blue-darken-1" @click="this.$emit('confirm')">Confirmar</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['visible', 'message', 'warning_message'],
    emits: ['close', 'confirm'],
    computed: {
        local_visible: {
            get() {
                return this.visible;
            }
        }
    }
}
</script>
