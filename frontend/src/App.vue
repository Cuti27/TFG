<template>
  <v-app class="bgImg">
    <div id="mainContent" :class="{ center: true, move: !collapse }">
      <div v-if="windowWidth < 500" id="nav" :class="{ change: !collapse }">
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
            <v-registro-id :show="!collapse"></v-registro-id>
            <v-btn
              color="primary"
              elevation="5"
              outlined
              rounded
              @click="logout()"
              v-show="!collapse"
              >Cerrar sesion</v-btn
            >
          </div>
          <div v-else class="login">
            <v-registro :show="!collapse"></v-registro>
            <v-login :show="!collapse"></v-login>
          </div>
        </div>
        <div slot="toggle-icon"><font-awesome-icon icon="arrows-alt-h" /></div>
      </sidebar-menu>

      <v-main @click="touchOut()">
        <!-- Provides the application the proper gutter -->
        <v-container fluid>
          <!-- If using vue-router -->
          <transition name="slide" mode="out-in">
            <div>
              <v-dialog
                transition="dialog-bottom-transition"
                :value="isLoading"
                persistent
                width="300"
              >
                <v-card color="primary" dark>
                  <v-card-text>
                    Procesando
                    <v-progress-linear
                      indeterminate
                      color="white"
                      class="mb-0"
                    ></v-progress-linear>
                  </v-card-text>
                </v-card>
              </v-dialog>
              <v-alert
                class="onTop"
                v-if="comunicationError"
                dismissible
                border="left"
                color="red"
                type="error"
                transition="scale-transition"
                @input="closeError"
                >{{ comunicationError }}</v-alert
              >

              <div class="text-center">
                <v-snackbar :value="snackbar" :timeout="timeout">
                  {{ text }}

                  <template v-slot:action="{ attrs }">
                    <v-btn
                      color="blue"
                      text
                      v-bind="attrs"
                      @click="snackbar = false"
                    >
                      Cerrar
                    </v-btn>
                  </template>
                </v-snackbar>
              </div>
              <router-view />
            </div>
          </transition>
        </v-container>
      </v-main>

      <custom-footer :class="{move: !collapse}"></custom-footer>
    </div>
  </v-app>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

import { SidebarMenu } from "vue-sidebar-menu";
import customFooter from "@/components/vuetify/footer";
import vLogin from "@/components/vuetify/dialog/newLogin";
import vRegistro from "@/components/vuetify/dialog/newRegistro";
import vRegistroId from "@/components/vuetify/dialog/generateId";

// import StickyHeader from "@/components/StickyHeader";
export default {
  components: {
    customFooter,
    SidebarMenu,
    vLogin,
    vRegistro,
    vRegistroId,
  },
  computed: {
    ...mapGetters([
      "showLogin",
      "showRegistro",
      "auth",
      "comunicationError",
      "isLoading",
    ]),
    ...mapGetters({
      snackbar: "comunicationSuccess",
      text: "comunicationSuccess",
    }),
    logged() {
      return this.auth != null && this.auth != "";
    },
  },
  data() {
    return {
      showProgramador: false,
      windowWidth: 0,
      windowHeight: 0,
      cabezales: this.$root.cabezales,
      programas: this.$root.programas,
      dias: [false, false, false, false, false, true, true],
      checked: false,
      collapse: false,

      timeout: 5000,
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
        {
          href: { name: "Cabezales" },
          title: "Cabezales",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "house-user",
            },
          },
        },
        {
          href: { name: "Programas" },
          title: "Programas",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "clock",
            },
          },
        },
        {
          href: { name: "Registrar programador" },
          title: "Registrar programador",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "clock",
            },
          },
        },
      ],
    };
  },
  methods: {
    ...mapActions([
      "updateLogin",
      "updateRegistro",
      "getAnalogicalInput",
      "getAnalogicalOutput",
      "getDigitalInput",
      "getDigitalOutput",
      "getTypeDevice",
      "logout",
      "closeError",
    ]),
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
  created() {
    this.getAnalogicalInput();
    this.getAnalogicalOutput();
    this.getDigitalInput();
    this.getDigitalOutput();
    this.getTypeDevice();
  },
};
</script>

<style lang="scss">
@import "src/css/colorSchema.scss";
$primary-color: $primary;
$icon-color: darken($primaryDark, 10%);
$input-text-align: center;

@import "vue-sidebar-menu/src/scss/vue-sidebar-menu.scss";

.center {
  margin: 0 auto;
  margin-left: 50px;
  max-width: 1980px;
  height: 100%;
  width: -webkit-calc(100% - 50px);
  width: -moz-calc(100% - 50px);
  width: calc(100% - 50px);
}

.bgImg {
  background-color: $base;
  background-image: url("./assets/leaves.png") !important;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  height: 100%;
  width: 100%;
}

h3 {
  font-size: 1.25rem !important;
}

.slide-enter-active,
.slide-leave-active {
  transition: opacity 1s, transform 0.5s;
}

.slide-enter,
.slide-leave-to {
  opacity: 0;
  transform: translateY(90%);
}

.move {
  width: -webkit-calc(100% - 270px);
  width: -moz-calc(100% - 270px);
  width: calc(100% - 270px);
  margin-left: 220px;
}
.container {
  display: inline-block;
}
.v-sidebar-menu {
  max-height: 100vh;
  z-index: 9990;
  position: fixed;
  .vsm--title {
    color: black;
  }
}

.login,
.auxiliares {
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
  background-color: $white;
  overflow: hidden;
  border-radius: 5px;
  background: linear-gradient(145deg, #ffffff, #e6e6e6);
  box-shadow: 20px 20px 60px #d9d9d9, -20px -20px 60px #ffffff;
}

.v-sidebar-menu {
  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;

  .vsm--toggle-btn {
    background-color: $primary !important;
  }
}

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

  box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;

  main {
    flex: 1 0 auto;
    padding-bottom: 120px !important;
  }

  footer {
    position: absolute;
    bottom: 0;
    width: -webkit-calc(100% - 50px);
    width: -moz-calc(100% - 50px);
    width: calc(100% - 50px);
    max-width: 1980px;
    flex: 1 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: $white;
    padding: 0px;
    background-color: $white;
    flex-shrink: 0;
    margin-top: 30px;
    color: $black;
    border-top: 1px solid $black;

    &.move {
      margin: 0px;
      width: -webkit-calc(100% - 220px);
      width: -moz-calc(100% - 220px);
      width: calc(100% - 220px);
    }

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

  // .move {
  //   width: calc(99vw - 50px);
  // }
}

.menuHamburguesa {
  display: none;
}

.onTop {
  position: fixed !important;
  z-index: 9950;
  top: 10px;
}

@media (max-width: "480px") {
  #app .move {
    width: 98vw;
  }
  #nav.change {
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
  .center {
    margin-left: 0px;
  }

  footer {
    margin-left: 0px !important;
  }
}

@media (min-width: "1980px"){
  #mainContent{
    margin: 0 auto;
  }
}
</style>
