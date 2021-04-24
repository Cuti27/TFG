<template>
  <div id="app">
    <div v-if="windowWidth < 500" id="nav" :class="{change: !collapse}">
      <div
        :class="{ container: true, change: !collapse, menuHamburguesa: true }"
        @click="collapse = !collapse"
      >
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
      </div>
    </div>
    <sidebar-menu
      width="200px"
      :menu="menu"
      :collapsed="collapse"
      theme="white-theme"
      @toggle-collapse="collapse = !collapse"
      @item-click="collapse = true"
    >
      <div slot="header" v-if="!collapse">
        <img src="./assets/Logo.png" width="200px" alt="" />
      </div>
      <div slot="footer">
        <div v-if="logged" class="auxiliares">
          
          <login-button @click="showProgramador = true; collapse = true" v-show="!collapse">Añadir dispositivo</login-button>
          <login-button  v-show="!collapse">Cerrar sesion</login-button>
          <login-button @click="showProgramador = true; collapse = true" v-show="collapse"><font-awesome-icon icon="plus-square" /></login-button>
        </div>
        <div v-else  class="login">
          <login-button @click="showLogin = true; collapse = true" v-show="!collapse">Login</login-button>
          <login-button @click="showRegistro = true; collapse = true" v-show="!collapse">Registro</login-button>
          <login-button @click="showLogin = true; collapse = true" v-show="collapse"><font-awesome-icon icon="sign-in-alt" /></login-button>
        </div>
      </div>
      <div slot="toggle-icon"><font-awesome-icon icon="arrows-alt-h" /></div>
    </sidebar-menu>

    <div @click="touchOut()" :class="{ main: true, move: !collapse }"> 
      <transition name="slide" mode="out-in">
        <router-view/>
      </transition>
      <modal v-if="showLogin || showRegistro || showProgramador" @close="showLogin = false; showRegistro = false">
          <login v-if="showLogin" @registro="showLogin = false; showRegistro = true"></login>
          <registro v-if="showRegistro" @login="showLogin = true; showRegistro = false"></registro>
          <add-programador v-if="showProgramador"></add-programador>
      </modal>
    </div>
    <footer :class="{ move: !collapse }">
      <div>
        <a href="/">Genhidro</a>
        |
        <a href="https://agrosolmen.es/">Agrosolmen</a>
        |
        <a href="/aviso-legal">Aviso Legal</a>
        |
        <a href="/politica-de-privacidad">Política de Privacidad</a>
        |
        <a href="/politica-de-cookies">Política de Cookies</a>
      </div>
      <div class="SocialMedia">
        <ul class="social-icons">
          <li>
            <a
              href="https://es-es.facebook.com/pages/category/Agricultural-Cooperative/Agrosolmen-1461731994040377/"
              ><font-awesome-icon :icon="['fab', 'facebook-f']"
            /></a>
          </li>
          <li>
            <a href="https://www.linkedin.com/company/agrosolmen/"
              ><font-awesome-icon :icon="['fab', 'linkedin-in']"
            /></a>
          </li>
        </ul>
      </div>
    </footer>
  </div>
</template>

<script>
import { SidebarMenu } from "vue-sidebar-menu";
import loginButton from "@/components/LoginButton";
import modal from "@/components/Modal";
import login from "@/components/Modals/Login";
import registro from "@/components/Modals/Registro";
import addProgramador from "@/components/Modals/AddProgramador";

// import StickyHeader from "@/components/StickyHeader";
export default {
  components: {
    SidebarMenu,
    loginButton,
    modal,
    login,
    registro,
    addProgramador,
  },
  data() {
    return {
      showLogin: false,
      showRegistro: false,
      showProgramador: false,
      windowWidth: 0,
      windowHeight: 0,
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
          title: "Home",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "home",
            },
          },
        },
        {
          href: { name: "Prueba" },
          title: "Pruebas",
          icon: {
            element: "font-awesome-icon",
            attributes: {
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
              icon: "leaf",
            },
          },
        },
      ],
      logged: false,
    };
  },
  methods: {
    touchOut() {
      if (!this.collapse) this.collapse = true;
    },
    getWindowWidth() {
      this.windowWidth = document.documentElement.clientWidth;
    },

    getWindowHeight() {
      this.windowHeight = document.documentElement.clientHeight;
    },
  },
  mounted() {
    this.$nextTick(function () {
      window.addEventListener("resize", this.getWindowWidth);
      window.addEventListener("resize", this.getWindowHeight);

      //Init
      this.getWindowWidth();
      this.getWindowHeight();
    });
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.getWindowWidth);
    window.removeEventListener("resize", this.getWindowHeight);
  },
};
</script>



<style lang="scss">
@import "src/css/colorSchema.scss";
$primary-color: $primary;
$icon-color: darken($primaryDark, 10%);

@import "vue-sidebar-menu/src/scss/vue-sidebar-menu.scss";

.slide-enter-active,
.slide-leave-active {
  transition: opacity 0.5s, transform 0.5s;
}

.slide-enter,
.slide-leave-to {
  opacity: 0;
  transform: translateX(-30%);
}

.main {
  margin-left: 50px;
  flex-grow: 3;
}
.move {
  width: 100vw;
}
.container {
  display: inline-block;
  cursor: pointer;
}
.v-sidebar-menu{
  max-height: 100vh;
  z-index: 9990;
  position: fixed;
  box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
  .vsm--title {
    color: black;
  }
} 

.login, .auxiliares {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  margin: 5px;

  button {
    margin-top: 5px;
  }
}

#nav {
  position: fixed;
  top: 10px;
  left: 10px;
  z-index: 9995;
  background-color:$white;
  overflow: hidden;
  border-radius: 5px;
  background: linear-gradient(145deg, #ffffff, #e6e6e6);
box-shadow:  20px 20px 60px #d9d9d9,
             -20px -20px 60px #ffffff;
}

body {
  background-color: $base;
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
    flex: 1 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: $white;
    padding: 0px;
    background-color: $white;
    flex-shrink: 0;
    margin-top: 30px;
    margin-left: 50px;
    color: $black;
    border-top: 1px solid $black;

    a {
      text-decoration: none;
      transition-property: color, background-color, border-color;
      transition-duration: 0.2s;
      transition-timing-function: linear;
      color: #000;
      padding: 5px;

      &:hover {
        color: $primaryDark;
      }
    }

    $timing: 265ms;
    $iconColor: $primary;
    $accent: $primaryDark;
    $bluefade: $secondary;
    $gradient: #00b5f5;

    @mixin transformScale($size: 1) {
      transform: scale($size);
      -ms-transform: scale($size);
      -webkit-transform: scale($size);
    }

    .socialMedia {
      width: 400px;
      margin: 40vh auto;
      text-align: center;
    }

    .social-icons {
      padding: 0;
      list-style: none;
      margin: 1em;

      li {
        display: inline-block;
        margin: 0.15em;
        position: relative;
        font-size: 1.2em;
      }

      svg {
        color: #fff;
        position: absolute;
        top: 21px;
        left: 21px;
        transition: all $timing ease-out;
      }

      a {
        display: inline-block;
        padding: 0px;
        &:before {
          @include transformScale();
          content: " ";
          width: 60px;
          height: 60px;
          border-radius: 100%;
          display: block;
          background: linear-gradient(45deg, $iconColor, $accent);
          transition: all $timing ease-out;
        }

        &:hover:before {
          transform: scale(0);
          transition: all $timing ease-in;
        }

        &:hover svg {
          @include transformScale(2.2);
          color: $iconColor;
          background: -webkit-linear-gradient(45deg, $iconColor, $accent);
          background-clip: text;
          -webkit-text-fill-color: transparent;
          transition: all $timing ease-in;
        }
      }
    }
  }

  .move {
    width: calc(99vw - 50px);
  }
}

.menuHamburguesa {
  display: none;
}

@media (max-width: "480px") {
  #app .move {
    width: 98vw;
  }
  #nav.change{
    left: 220px;
  }
  .menuHamburguesa {
    display: inline;
    align-self: flex-start;
    .bar1,
    .bar2,
    .bar3 {
      width: 35px;
      height: 5px;
      background-color: $secondary;
      border-radius: 10px;
      margin: 6px 0;
      transition: 0.4s;
    }
  }
  .change {
    // .bar1,
    // .bar2,
    // .bar3 {
    //   // -webkit-transform:  translateX(300px);
    //   //  transform: translateX(300px);
    //   margin-left: 200px;
    //   border: 0px;
    // }

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

  footer {
    margin-left: 0px !important;
  }
}
</style>
