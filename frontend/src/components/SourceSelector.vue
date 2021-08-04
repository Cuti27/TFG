<template>
  <div class="sourceList">
    <div class="title">
      <slot></slot>
    </div>
    <div class="sources">
      <div
        
        v-for="(item, index) in options"
        :key="item + index"
        @click.prevent="toggle(index)"
      >
        <input :id="item + '-' + index" type="radio" />
        <label
          :class="{ blanco: !selected[index], sourceItem: true }"
          :for="item + '-' + index"
          >{{ item }}</label
        >
      </div>
    </div>
  </div>
</template>

<script>
//TODO: Definir si debemos poder poner muchas fuentes o únicamente 4
import Vue from "vue";
export default {
  props: {
    options: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      check: true,
      selected: [],
    };
  },
  beforeMount() {
    this.options.forEach(() => {
      this.selected.push(false);
    });
  },
  methods: {
    toggle(index) {
      console.log(this.selected[index]);
      Vue.set(this.selected, index, !this.selected[index]);
      console.log(this.selected[index]);
      this.$emit("toggle", this.selected);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.sourceItem{
  transition: all 0.5s ease;
  &:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 25px 0 rgba(34,41,47,.25);
  }
  
}

input,
label {
  background: $primaryDark;
  color: $white;
  user-select: none;
  min-width: 30px;
  transition: background 0.3s;
  border-radius: 8px;
}

label:hover {
  background: $primary;
}

input {
  display: none;
}

label {
  display: inline-block;
  padding: 5px;
  height: 50px;
  text-align: center;
  border: 2px;
  box-shadow: 2px 2px 4px $primaryShadow;
  margin: 5px;
  margin-bottom: 10px;
  line-height: 50px;
  cursor: pointer;
}

@media (max-width: 768px) {
  .label {
    padding: 3px;
    height: 30px;
    width: 30px;
  }
}

@media (max-width: 576px) {
  .label {
    padding: 2px;
    height: 25px;
    width: 25px;
  }
}

label.blanco {
  background-color: $white;
  color: $black;
  opacity: 0.3;
}

label.blanco:hover {
  opacity: 0.8;
}

.sourceList {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  flex-wrap: wrap;
}

.sources {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}
</style>
