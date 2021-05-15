<template>
  <v-dialog
    v-model="dialog"
    transition="dialog-bottom-transition"
    max-width="600"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="primary"
        elevation="5"
        outlined
        rounded
        :fab="!show"
        :small="!show"
        v-bind="attrs"
        v-on="on"
        ><div v-if="show">{{ btnText }}</div>
        <font-awesome-icon v-else icon="sign-in-alt" />
      </v-btn>
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
          <v-btn color="blue darken-1" text @click="dialog.value = false">
            {{ cancelText }}
          </v-btn>

          <v-btn
            v-if="submitText"
            color="blue darken-1"
            text
            @click="dialog.value = false;submit()"
          >
            {{ submitText }}
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
      required: true,
    },
    cancelText: {
      type: String,
      required: true,
    },
    titleText: {
      type: String,
      required: true,
    },
    submitText: {
      type: String,
      required: false,
    },
    show: {
      type: Boolean,
      requred: false,
    },
  },
  methods: {
    submit(){
      this.$emit('submit');
    }
  }
};
</script>

<style></style>
