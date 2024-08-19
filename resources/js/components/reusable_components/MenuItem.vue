<template>
  <v-list-item @click="action" :base-color="color">
    <template v-slot:prepend style="width: min-content;">
        <v-icon>mdi-{{ icon }}</v-icon>
    </template>
    <v-list-item-title >{{ text }}</v-list-item-title>
  </v-list-item>
</template>
<script>
export default {
  name: 'MenuItem',
  props: {
    icon: {
      type: String,
      default: '',
    },
    text: {
      type: String,
      default: '',
    },
    action: {
      type: Function,
      default: () => {},
    },
    color: {
        type: String,
        default: 'black'
    }
  },
};
</script>
