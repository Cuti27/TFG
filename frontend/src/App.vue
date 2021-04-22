<template>
  <div id="app">
    <!-- <div class="header">
      <sticky-header>
        <h3>Prueba</h3>
      </sticky-header>
    </div> -->
    <div v-if="windowWidth < 500" id="nav">
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
        <div class="login">
          <login-button @click="showLogin = true" v-show="!collapse">Login</login-button>
          <login-button @click="showRegistro = true" v-show="!collapse">Registro</login-button>
          <login-button @click="showLogin = true" v-show="collapse"><font-awesome-icon icon="sign-in-alt" /></login-button>
        </div>
      </div>
      <div slot="toggle-icon"><font-awesome-icon icon="arrows-alt-h" /></div>
    </sidebar-menu>

    <div @click="touchOut()" :class="{ main: true, move: !collapse }"> 
      <transition name="slide" mode="out-in">
        <router-view/>
      </transition>
      <modal v-if="showLogin || showRegistro" @close="showLogin = false; showRegistro = false">
          <login v-if="showLogin" @registro="showLogin = false; showRegistro = true"></login>
          <registro v-if="showRegistro" @login="showLogin = true; showRegistro = false"></registro>
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

// import StickyHeader from "@/components/StickyHeader";
export default {
  components: {
    SidebarMenu,
    loginButton,
    modal,
    login,
    registro
  },
  data() {
    return {
      showLogin: false,
      showRegistro: false,
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
  margin-left: 200px;
}
.container {
  display: inline-block;
  cursor: pointer;
}
.v-sidebar-menu .vsm--title {
  color: black;
}

.login {
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
  margin-left: 25px;
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
    margin-left: 200px;
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

  footer {
    margin-left: 0px !important;
  }
}
</style>
