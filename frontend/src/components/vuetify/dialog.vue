<template>
  <v-dialog transition="dialog-bottom-transition" max-width="600">
    <template v-slot:activator="{ on, attrs }">
      <v-btn color="primary" v-bind="attrs" v-on="on">{{ btnText }}</v-btn>
    </template>
    <template v-slot:default="dialog">
      <v-card>
        <v-toolbar v-if="titleText" color="primary" dark>{{
          titleText
        }}</v-toolbar>
        <v-container>
          <slot></slot>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">
            {{ cancelText }}
          </v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
export default {
  props: {
    btnText: {
        type: String,
        required: true
    },
    cancelText: {
        type: String,
        required: true
    },
    titleText: {
        type: String,
        required: true
    },
    submitText: {
        type: String,
        required: false
    },
  },
  data() {
    return {
      dialog: false,
    };
  },
};
</script>

<style></style>
