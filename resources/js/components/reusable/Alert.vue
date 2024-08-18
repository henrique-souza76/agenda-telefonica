<template>
    <transition name="fade">
        <v-container
            v-show="visible"
            class="position-fixed top-5"
            style="margin: 0 auto; left: 50%; transform: translateX(-50%); z-index: 2000"
            :elevation="3"
            max-width="700px"
        >
            <v-card
            style="
            position: relative;
            text-align: center;
            border-radius: 0 0 5px 5px;
            padding: 10px"
            :color="type"
            >
                <v-progress-linear
                    color="white"
                    height="5"
                    :model-value="progress_bar"
                    style="
                    position: absolute;
                    top: 0;
                    left: 0"
                ></v-progress-linear>
                <v-card-title>{{ message }}</v-card-title>
            </v-card>
        </v-container>
    </transition>
</template>
<script>
export default {
    data() {
        return {
            progress_bar: 0,
            interval: 0
        }
    },
    //Type: error, warning, success
    props: ['type', 'visible', 'message'],
    emits: ['close'],
    watch: {
        visible(value) {
            if(value) {
                setTimeout(() => {
                    this.$emit('close');
                }, 2000);

                this.ResetProgressBar();
                this.SetupProgressBar();
            }
        }
    },
    methods: {
        SetupProgressBar() {
            this.interval = setInterval(() => {
                this.progress_bar += 3.75;
            }, 60);
        },
        ResetProgressBar() {
            clearInterval(this.interval);
            this.progress_bar = 0;
        }
    }
}
</script>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s linear;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
