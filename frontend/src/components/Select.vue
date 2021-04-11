<template>
  <div class="selector">
      <div class="arrow izquierda">
          <font-awesome-icon icon="arrow-circle-left" @click="before()" size="lg"/>
      </div>
      <select v-model="selected" name="" id="" required>
          <option v-for="(value, index) in values" :key="value+index" :value="index">{{value}}</option>
      </select>
      <div class="arrow">
           <font-awesome-icon icon="arrow-circle-right" @click="next()" size="lg" />
      </div>
  </div>
</template>

<script>
export default {
    props: {
        values: Array,
    },
    data() {
        return {
            selected: "0"
        }
},methods: {
    next(){
        this.selected = (this.selected+1)%this.values.length;
    },
    before(){
        this.selected = (this.selected-1) < 0 ? this.values.length - 1: this.selected-1;
    }
}
}
</script>

<style lang="scss" scoped>

.selector{
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

select{
    -webkit-appearance: none;
    -moz-appearance: none;
    text-indent: 1px;
    text-overflow: '';
}

.arrow {
    margin: auto 10px;
}


</style>