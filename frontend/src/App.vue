<template>
  <div id="app">
    <!-- <div class="header">
      <sticky-header>
        <h3>Prueba</h3>
      </sticky-header>
    </div> -->
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
          <img v-if="!collapse" src="./assets/Logo.png" width="200px" alt="" />
        </div>
        <div slot="toggle-icon"><font-awesome-icon icon="arrows-alt-h" /></div>
      </sidebar-menu>
    </div>
    <div @click="touchOut()" :class="{ main: true, move: !collapse }">
      <router-view />
    </div>
    <footer>
      <p class="cp-text">© Copyright 2021 Cuti27. All rights reserved.</p>
    </footer>
  </div>
</template>

<script>
import { SidebarMenu } from "vue-sidebar-menu";
// import StickyHeader from "@/components/StickyHeader";
export default {
  components: {
    SidebarMenu,
    // StickyHeader
  },
  data() {
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
          icon: {
            element: "font-awesome-icon",
            attributes: {
              // icon props:
              icon: "wrench",
            },
          },
        },
        {
          href: { name: "ProgramView" },
          title: "ProgramView",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              // icon props:
              icon: "faucet",
            },
          },
        },
        {
          href: { name: "Fertirrigacion" },
          title: "Fertirrigacion",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              // icon props:
              icon: "leaf",
            },
          },
        },
      ],
    };
  },
  methods: {
    touchOut() {
      if(!this.collapse)
        this.collapse= true;
    }
  }
};
</script>



<style lang="scss">
@import "src/css/colorSchema.scss";
$primary-color: $primary;
$icon-color: darken( $secondaryDark, 10% );

@import "vue-sidebar-menu/src/scss/vue-sidebar-menu.scss";




.main {
  margin-left: 50px;
  flex-grow: 3;
}
.move {
  margin-left: 200px;
}
.container {
  display: inline-block;
  cursor: pointer;
}
.v-sidebar-menu .vsm--title {
  color: black;
}

/* Rotate first bar */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;

  display: flex;
  align-items: space-between;
  justify-content: space-between;
  flex-direction: column;
  min-height: 100vh;
  box-sizing: border-box;

  main {
    flex: 1 0 auto;
  }

  footer {
    color: $white;
    padding: 18px 0px;
    background-color: $primary;
    flex-shrink: 0;
    margin-top: 30px;
    .cp-text {
      color: rgba(0, 0, 0, 0.7);
      text-shadow: 0 1px $secondaryShadow;
    }
  }
}

.menuHamburguesa {
  display: none;
}

@media (max-width: "480px") {
  .menuHamburguesa {
    display: inline;
    align-self: flex-start;
    .bar1,
    .bar2,
    .bar3 {
      width: 35px;
      height: 5px;
      background-color: $primaryDark;
      margin: 6px 0;
      transition: 0.4s;
    }
  }
  .change {
    .bar1,
    .bar2,
    .bar3 {
      // -webkit-transform:  translateX(300px);
      //  transform: translateX(300px);
      margin-left: 200px;
    }

    .bar1 {
      -webkit-transform: rotate(-45deg) translate(-9px, 6px);
      transform: rotate(-45deg) translate(-9px, 6px);
    }

    /* Fade out the second bar */
    .bar2 {
      opacity: 0;
    }

    /* Rotate last bar */
    .bar3 {
      -webkit-transform: rotate(45deg) translate(-8px, -8px);
      transform: rotate(45deg) translate(-8px, -8px);
    }
  }
  .v-sidebar-menu {
    transition: 0.3s all;
  }
  .v-sidebar-menu.vsm_collapsed {
    transform: translateX(-100%);
  }
  .main {
    margin-left: 0px;
  }
}
</style>
