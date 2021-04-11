<template>
  <div class="selector">
        <input
          type="number"
          class="form__field"
          placeholder="Name"
          name="name"
          id="name"
          :value="value"
           :min="min" :max="max"
          required
          @input="updateValue($event.target.value)"
        />
        <label for="name" class="form__label">{{placeholder}}</label>
      </div>
</template>

<script>
export default {
    props: {
        value: {
            type: Number
        },
        max: {
            type: Number,
        },
        min: {
            type: Number,
        },
        placeholder: {
            type: String
        }
    },
    methods: {
      updateValue(val){
         this.$emit('input', val)
      }
}

}
</script>

<style lang="scss" scoped>
$primary: #11998e;
$secondary: #38ef7d;
$white: #fff;
$gray: #9b9b9b;



.selector {
    position: relative;
    padding: 15px 5px 0;
    margin-top: 10px;
    width: 90px
  }

  .form__field {
    width: 100%;
    // Dibujamos unicamente la linea de abajo
    border: 0;
    border-bottom: 2px solid $gray;
    // Evitamos dibujar el borde
    outline: 0;
    font-size: 1.3rem;
    padding: 7px 0;
    background: transparent;
    transition: border-color 0.2s;

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
    color: $gray;
  }

  .form__field:focus {
    ~ .form__label {
      position: absolute;
      top: 0;
      display: block;
      transition: 0.2s;
      font-size: 1rem;
      color: $primary;
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
       border-bottom: 2px solid $gray;
    }
  }
</style>