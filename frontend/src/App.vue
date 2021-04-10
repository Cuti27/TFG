<template>
  <div id="app">
    <div id="nav">
      <div
        :class="{ container: true, change: !collapse, menuHamburguesa: true }"
        @click="collapse = !collapse"
      >
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
      </div>
      <sidebar-menu
        width="200px"
        :menu="menu"
        :collapsed="collapse"
        theme="white-theme"
        @toggle-collapse="collapse = !collapse"
      >
        <div slot="header">
          <img v-if="!collapse" src="./assets/Logo.png" width="200px" alt="">
        </div>
        <div  slot="toggle-icon"
          >toggle-icon</div
        >
      </sidebar-menu>
    </div>
    <div class="main">
      <router-view />
    </div>
    
  </div>
</template>

<script>
import { SidebarMenu } from "vue-sidebar-menu";
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
export default {
  components: {
    SidebarMenu,
  },data() {
    return {
      cabezales: this.$root.cabezales,
      programas: this.$root.programas,
      dias: [false, false, false, false, false, true, true],
      checked: false,
      collapse: false,
      menu: [
        {
          header: true,
          title: "Main Navigation",
          hiddenOnCollapse: true,
        },
        {
          href: { name: "Home" },
          title: "Pruebas",
          icon: "fa fa-user",
          class: 'vsm--link_active'
        },
        {
          href: { name: "ProgramView" },
          title: "ProgramView",
          icon: "fa fa-chart-area",
        },
      ],
    };
  },
};
</script>



<style lang="scss">
.main {
  margin-left: 50px;
}
.container {
  display: inline-block;
  cursor: pointer;
}

.bar1,
.bar2,
.bar3 {
  width: 35px;
  height: 5px;
  background-color: #333;
  margin: 6px 0;
  transition: 0.4s;
}

/* Rotate first bar */
.change .bar1 {
  -webkit-transform: rotate(-45deg) translate(-9px, 6px);
  transform: rotate(-45deg) translate(-9px, 6px);
}

/* Fade out the second bar */
.change .bar2 {
  opacity: 0;
}

/* Rotate last bar */
.change .bar3 {
  -webkit-transform: rotate(45deg) translate(-8px, -8px);
  transform: rotate(45deg) translate(-8px, -8px);
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}

.menuHamburguesa {
  display: none;
}

.v-sidebar-menu.vsm--link_active{
  background-color: #fff;
  color: #333
}

@media (max-width: "480px") {
  .menuHamburguesa {
    display: inline-block;
  }
  .v-sidebar-menu {
    transition: 0.3s all;
  }
  .v-sidebar-menu.vsm_collapsed {
    transform: translateX(-100%);
  }
}
</style>
