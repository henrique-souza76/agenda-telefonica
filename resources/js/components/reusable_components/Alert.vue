<template>
    <transition name="fade">
        <v-container
            v-if="visible"
            class="position-fixed top-5"
            style="margin: 0 auto; left: 50%; transform: translateX(-50%); z-index: 2000;"
            :elevation="3"
            max-width="700px"
        >
            <v-card
            style="
            position: relative;
            text-align: center;
            padding: 10px"
            :color="type"
            class="alert-message"
            > {{ message }}</v-card>
        </v-container>
    </transition>
</template>
<script>
export default {
    //Type: error, warning, success
    props: ['type', 'visible', 'message'],
    emits: ['close'],
    watch: {
        visible(value) {
            if(value) {
                setTimeout(() => {
                    this.$emit('close');
                }, 2300);
            }
        }
    }
}
</script>
<style scoped>
.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-leave-to {
  opacity: 0;
}
</style>
