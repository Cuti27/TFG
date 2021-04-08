<template>
  <div id="component">
    <slot></slot>
    <ul>
      <li v-for="a in data" :key="a.id">
        <div class="list">
          <div class="name">{{ format(a) }}</div>
          <div class="sectores" v-if="a.sectores">
            Sectores: {{ a.sectores }}
          </div>
          <div v-if="a.info && a.info instanceof Date" class="second">
            {{ formatDate(a.info) }}
          </div>
          <div v-if="a.horaInicio" class="second">
            Hora de inicio: {{ formatDate(a.horaInicio) }}
          </div>
          <div v-if="a.info && a.info instanceof Array" class="second">
            <i
              v-for="(dia, index) in a.info"
              :key="`${a.id}-${index}`"
              :class="{ blanco: dia }"
              >{{ formatWeek(index) }}</i
            >
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
const days = ["L", "M", "X", "J", "V", "S", "D"];
export default {
  props: ["data"],
  methods: {
    format(data) {
      return `[${data.id}] ${data.name}`;
    },
    formatDate(date) {
      return `${date.getDate() < 10 ? "0" + date.getDate() : date.getDate()}/${
        date.getMonth() < 10 ? "0" + date.getMonth() : date.getMonth()
      }/${date.getFullYear()} - ${
        date.getHours() < 10 ? "0" + date.getHours() : date.getHours()
      }:${
        date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes()
      }`;
    },
    formatWeek(index) {
      return days[index];
    },
  },
};
</script>
 
    
   
<style lang="scss" scoped>
@import "src/css/colorSchema.scss";

i {
  display: inline-block;
  background-color: $dirt;
  border-radius: 50% 50%;
  border: 2px;
  box-shadow: 2px 2px 4px $darkGreen;
  padding: 0.5em 0.6em;
  font-weight: bold;
  color: white;
}

i.blanco {
  background-color: white;
  color: black;
}

@media (max-width: 600px) {
  div#component {
    ul {
      li {
        div.list {
          flex-direction: column;
        }
      }
    }
  }
}

div#component {
  box-sizing: border-box;
  overflow: auto;
  max-height: 350px;
  border: solid;
  ul {
    list-style: none;
    padding: 0px;

    li {
      border: solid;
      margin: 5px;
      text-align: start;
      padding: 10px;
      box-shadow: 10px 5px 5px $darkGreen;

      div.list {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        div.name {
          padding: 3px;
          text-align: start;
        }
        div.sectores {
          padding: 3px;
        }
        div.second {
          padding: 3px;
          text-align: end;
        }
      }
    }
    li:hover {
      background-color: $ligthGreen;
      cursor: pointer;
      color: lightgray;
    }
  }
}
</style>