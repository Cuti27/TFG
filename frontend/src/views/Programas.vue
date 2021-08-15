<template>
  <div>
    <!-- Header -->
    <header-custom
      :name="`Cabezal: ${selectedHead.name}`"
    ></header-custom>

    <table-program></table-program>

    <div class="retroceder mt-5">
        <submit-button class="ma-2" @click="resetPage()">Retroceder</submit-button>
      </div>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import tableProgram from "@/components/vuetify/tableProgram";
import SubmitButton from "@/components/SubmitButton";
import { mapGetters } from "vuex";

export default {
  components: {
    headerCustom,
    tableProgram,
    SubmitButton
  },
  data() {
    return {
      remove: false,
    };
  },
  computed: {
    ...mapGetters(["selectedHead"]),
  },
  methods: {
    resetPage(){
      this.$router.push("Cabezales");
    }
  }
};
</script>

<style lang="scss">
@import "@/css/colorSchema.scss";
.retroceder {
  box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
  border-radius: 5px;
  margin: 0 auto;
  margin-bottom: 10px;
  padding: 10px 15px;
  background: $white;
  width: 100%;
}

.customTable table .dayList .size {
  width: 35px;
  height: 35px;
  line-height: 35px;
}
</style>
