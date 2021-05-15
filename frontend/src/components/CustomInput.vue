<template>
  <div class="input">
    <input
      :ref="'inputPanel' + placeholder"
      :type="type === '' ? 'text' : type"
      class="form__field"
      :placeholder="placeholder"
      :name="type + placeholder + 'login'"
      :id="type + placeholder + 'id'"
      :max="max"
      :min="min"
      :value="value"
      :step="step"
      @input="$emit('input', $event.target.value)"
    />
    <label @click="focus()" for="name" class="form__label">{{
      placeholder
    }}</label>
  </div>
</template>

<script>
export default {
  props: {
    value: [String, Number],
    placeholder: String,
    type: String,
    max: String,
    min: String,
    step: [Number, String],
  },
  methods: {
    focus() {
      this.$refs["inputPanel" + this.placeholder].focus();
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.input {
  position: relative;
  padding: 15px 5px 0;
  margin-top: 10px;
  width: 80%;
  margin: 5px;
}

.form__field {
  width: 100%;
  // Dibujamos unicamente la linea de abajo
  border: 0;
  border-bottom: 2px solid $secondary;
  // Evitamos dibujar el borde
  outline: 0;
  font-size: 1.3rem;
  padding: 7px 0;
  background: transparent;
  transition: border-color 0.3s;

  &::placeholder {
    color: transparent;
  }

  &:placeholder-shown ~ .form__label {
    font-size: 1.3rem;
    cursor: text;
    top: 20px;
  }
}

.form__label {
  position: absolute;
  top: 0;
  display: block;
  transition: 0.2s;
  font-size: 1rem;
  color: $dirt;
}

.form__field:focus {
  ~ .form__label {
    position: absolute;
    top: 0;
    display: block;
    transition: 0.2s;
    font-size: 1rem;
    color: $secondaryDark;
    font-weight: 700;
  }
  padding-bottom: 6px;
  font-weight: 700;
  border-width: 3px;
  border-image: linear-gradient(to right, $primary, $secondary);
  border-image-slice: 1;
}
/* reset input */
.form__field {
  &:required,
  &:invalid {
    box-shadow: none;
    border-bottom: 2px solid $secondaryDark;
  }
}
</style>
