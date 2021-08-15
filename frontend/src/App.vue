<template>
  <v-app class="bgImg">
    <div id="mainContent" :class="{ center: true, move: !collapse }">
      <nav v-show="windowWidth < 500" id="mainNavigation">
        <v-img src="./assets/Logo.png" max-height="60" max-width="60"> </v-img>
        <div
          :class="{ change: !collapse, menuHamburguesa: true }"
          @click="collapse = !collapse"
        >
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
        </div>
      </nav>
      <sidebar-menu
        :width="windowWidth < 500 ? '100%' : '200px'"
        :menu="logged ? menuLogged : menuNoLogged"
        :collapsed="collapse"
        theme="white-theme"
        @toggle-collapse="collapse = !collapse"
        @item-click="collapse = true"
      >
        <div v-if="logged" class="slotHeader noselect" slot="header">
          <img v-if="!collapse" src="./assets/Logo.png" width="200px" alt="" />
          <router-link @click.native="collapse = true" to="Profile" tag="div">
            <div :class="{ profile: true, border: !collapse }">
              <div class="pIcon ml-1">
                <v-spacer></v-spacer>
                <v-avatar color="primary" size="36px">
                  <v-img v-if="user.img" :src="user.img"></v-img>
                  <span v-else>{{ userInitial }}</span>
                </v-avatar>
                <v-spacer></v-spacer>
                <v-divider class="mx-1" inset vertical></v-divider>
              </div>
              <div
                :class="{ pInfo: true, 'text-align-center': windowWidth < 500 }"
                v-if="!collapse"
              >
                <strong> {{ user.name }} </strong><br />
                <span> {{ user.phone }} </span><br />
                <span>
                  {{ user.email }}
                </span>
              </div>
            </div>
          </router-link>
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

      <v-main @click="touchOut()" :class="{ 'mt-10': windowWidth < 500 }">
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
                    <v-btn color="blue" text v-bind="attrs" @click="offSnacbar">
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

      <custom-footer :class="{ 'move-footer': !collapse }"></custom-footer>
    </div>
  </v-app>
</template>

<script>
import { mapActions, mapGetters, mapState } from "vuex";

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
    ...mapState(["user"]),
    ...mapGetters([
      "showLogin",
      "showRegistro",
      "auth",
      "comunicationError",
      "isLoading",
      "windowWidth",
      "windowHeight",
    ]),
    ...mapGetters({
      snackbar: "comunicationSuccess",
      text: "comunicationSuccess",
    }),
    logged() {
      return this.auth != null && this.auth != "";
    },
    userInitial() {
      if (!this.user || !this.user.name) return "";
      let rgx = new RegExp(/(\p{L}{1})\p{L}+/, "gu");

      let initials = [...this.user.name.matchAll(rgx)] || [];

      initials = (
        (initials.shift()?.[1] || "") + (initials.pop()?.[1] || "")
      ).toUpperCase();

      return initials;
    },
    menuLogged() {
      let menu = [
        ...this.menuNoLogged,
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
      ];

      if (this.$route.name != "Cabezales" && this.$route.name != "Home" && this.$route.name != "Profile") {
        menu.push({
          href: { name: "Programas" },
          title: "Programas",
          icon: {
            element: "font-awesome-icon",
            attributes: {
              icon: "clock",
            },
          },
        });
        if (this.$route.name != "Programas") {
          if (this.$route.name == "Registrar programador") {
            menu.push({
              href: { name: "Registrar programador" },
              title: "Registrar programador",
              icon: {
                element: "font-awesome-icon",
                attributes: {
                  icon: "clock",
                },
              },
            });
          } else {
            menu.push({
              href: { name: "Creador programa" },
              title: "Creador programa",
              icon: {
                element: "font-awesome-icon",
                attributes: {
                  icon: "faucet",
                },
              },
            });
            if (this.$route.name != "Creador programa") {
              menu.push({
                href: { name: "Fertirrigacion" },
                title: "Fertirrigacion",
                icon: {
                  element: "font-awesome-icon",
                  attributes: {
                    icon: "leaf",
                  },
                },
              });
            }
          }
        }
      }

      return menu;
    },
  },
  data() {
    return {
      message: {
        avatar: "https://avatars0.githubusercontent.com/u/9064066?v=4&s=460",
        name: "John Leider",
        title: "Welcome to Vuetify!",
        excerpt: "Thank you for joining our community...",
      },
      showProgramador: false,
      cabezales: this.$root.cabezales,
      programas: this.$root.programas,
      dias: [false, false, false, false, false, true, true],
      checked: false,
      collapse: false,

      timeout: 5000,
      menuNoLogged: [
        {
          header: false,
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
      "updateWindowWidth",
      "updateWindowHeight",
      "fetchUser",
      "offSnacbar",
    ]),
    touchOut() {
      if (!this.collapse) this.collapse = true;
    },
    windowsW() {
      this.updateWindowWidth(document.documentElement.clientWidth);
    },
    windowsH() {
      this.updateWindowHeight(document.documentElement.clientHeight);
    },
  },

  mounted() {
    this.$nextTick(function () {
      window.addEventListener("resize", this.windowsW);
      window.addEventListener("resize", this.windowsH);

      this.updateWindowWidth(document.documentElement.clientWidth);
      this.updateWindowHeight(document.documentElement.clientHeight);
    });
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.windowsW);
    window.removeEventListener("resize", this.windowsH);
  },
  beforeMount() {
    if (!this.user) {
      this.fetchUser();
    }
  },
  created() {
    this.getAnalogicalInput();
    this.getAnalogicalOutput();
    this.getDigitalInput();
    this.getDigitalOutput();
    this.getTypeDevice();
    this.fetchUser();

    if (performance.navigation.type == 1){
      this.$router.push("Cabezales");
    }
  },
};
</script>

<style lang="scss">
@import "src/css/colorSchema.scss";
$primary-color: $primary;
$icon-color: darken($primaryDark, 10%);
$input-text-align: center;
.toggle-btn {
  height: 60px !important;
}

@import "vue-sidebar-menu/src/scss/vue-sidebar-menu.scss";

.text-align-center {
  text-align: center;
}

.slotHeader {
  max-height: 240px;

  .profile {
    display: grid;
    grid-template-rows: 1fr;
    grid-template-columns: auto;
    grid-template-areas: "pIcon";
    padding-left: 5px;
    padding: 1px;
    max-height: 36px;
    margin: 5px 1px;
    transition: all 0.5s ease;
    cursor: pointer;

    &.border {
      box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
      border: 1px solid black;
      max-height: 75px;
      grid-template-rows: 1fr 2fr;
      grid-template-areas: "pIcon pInfo";
    }

    &:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 25px 0 rgba(34, 41, 47, 0.25);
      background: rgba(200, 200, 200, 0.5);
    }

    .pIcon {
      grid-area: pIcon;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .pInfo {
      grid-area: pInfo;
      font-size: 14px;
      text-overflow: ellipsis;
      min-height: 70px;
      overflow: hidden;
    }
  }
}

nav#mainNavigation {
  display: flex;
  justify-content: flex-end;
  padding-right: 25px;
  padding-top: 5px;
  padding-bottom: 5px;
  background-color: rgba(255, 255, 255, 1);
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 999;
  border-radius: 0px 0px 25px 25px;
  border: 1px solid black;
  margin: 0px auto;
}

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

.noselect {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
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
  .center {
    margin: 0 auto;
  }
  // #app .move {
  //   width: 98vw;
  // }
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
      :hover > & {
        box-shadow: 0 4px 25px 0 rgba(34, 41, 47, 0.25);
      }
    }
  }
  .change {
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

  #mainContent {
    margin: 0px;
    width: 100vw;
  }
}

@media (min-width: "1980px") {
  #mainContent {
    margin: 0 auto;
  }
}
</style>
