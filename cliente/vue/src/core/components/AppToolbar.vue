<template>
  <v-app-bar
    color="primary"
    fixed
    dark
    text
    app
    clipped-left
  >
    <div class="toolbar-logo theme--dark primary darken-1">
      <v-app-bar-nav-icon
        class="hidden-md-and-up"
        @click="drawerModel = !drawerModel"
      />
      <img
        :src="require('@/assets/logomarca_municipio_mais_cidadao.png')"
        alt="Logo do Sistema"
        max-width="200"
      >
      <v-btn
        class="button-drawer mx-2 hidden-sm-and-down"
        fab
        dark
        small
        color="primary darken-1"
        @click="drawerModel = !drawerModel"
      >
        <v-icon dark>
          {{ drawerModel ? 'chevron_right' : 'chevron_left' }}
        </v-icon>
      </v-btn>
    </div>
    <v-toolbar-title class="ml-10">
      <v-col class="caption font-weight-bold" style="margin-left: 40px;">
        CPF : <span
        class="font-weight-regular">{{ usuarioLogadoGetter.nu_cpf | mxFiltroFormatarCPFCNPJ }}</span><br/>
        E-mail : <span class="font-weight-regular">{{ usuarioLogadoGetter.ds_email }}</span>
      </v-col>
    </v-toolbar-title>
    <v-spacer />
    <v-toolbar-items>
      <v-btn
        icon
        @click="handleFullScreen()"
      >
        <v-icon>fullscreen</v-icon>
      </v-btn>
      <v-menu
        offset-y
        origin="center center"
        :nudge-bottom="10"
        transition="scale-transition"
        :close-on-content-click="false"
      >
        <template v-slot:activator="{ on }">
          <v-btn
            slot="activator"
            icon
            large
            text
            v-on="on"
          >
            <v-avatar color="primary">
              <v-icon
                medium
                dark
              >
                account_circle
              </v-icon>
            </v-avatar>
          </v-btn>
        </template>
        <v-card>
          <v-list>
            <v-list-item>
              <v-list-item-avatar>
                <v-icon medium>
                  account_circle
                </v-icon>
              </v-list-item-avatar>
              <v-list-item-content>
                <v-list-item-title>
                  {{ usuarioLogadoGetter.no_usuario }}
                </v-list-item-title>
                <v-list-item-subtitle>
                  {{ usuarioLogadoGetter.nu_cpf | mxFiltroFormatarCPFCNPJ }}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          <v-divider />
          <v-divider />
          <v-list>
            <v-list-item
              v-for="(item, index) in items"
              :key="index"
              :href="item.href"
              ripple="ripple"
              :disabled="item.disabled"
              :target="item.target"
              rel="noopener"
              @click="item.click"
            >
              <v-list-item-action v-if="item.icon">
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-card>
      </v-menu>
    </v-toolbar-items>
  </v-app-bar>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
import NotificationList from '@/core/components/widgets/list/NotificationList';
import Util from '../util';
import MxFiltros from '@/modules/shared/mixins/filters';
import * as service from '../../modules/shared/service/base/index';

export default {
  name: 'AppToolbar',
  components: {
    NotificationList,
  },
  mixins: [
    MxFiltros,
  ],
  data() {
    return {
      appTitle: process.env.VUE_APP_TITLE,
      perfilAtivo: {},
      items: [
        {
          icon: 'settings',
          href: '',
          title: 'Tema',
          click: this.abrirConfiguracoesDoTema,
        },
        {
          icon: 'exit_to_app',
          href: '',
          title: 'Logout',
          click: this.handleLogut,
        },
      ],
    };
  },
  computed: {
    ...mapGetters({
      usuarioLogadoGetter: 'app/usuarioLogado',
      perfilAtivoGetter: 'app/perfilAtivo',
      menuPrincipalGetter: 'app/primaryDrawer',
    }),
    drawerModel: {
      get() {
        return this.menuPrincipalGetter.model;
      },
      set(value) {
        this.setMenuPrincipalAction(
          Object.assign({}, this.menuPrincipalGetter, { model: value }),
        );
      },
    },
    toolbarColor() {
      return this.$vuetify.options.extra.mainNav;
    },
  },
  mounted() {
    this.perfilAtivo = this.perfilAtivoGetter;
  },
  methods: {
    ...mapActions({
      setMenuAction: 'app/setMenu',
      setPerfilAtivoAction: 'app/setPerfilAtivo',
      setMenuPrincipalAction: 'app/setPrimaryDrawer',
      toggleDrawerThemeAction: 'app/toggleDrawerTheme',
    }),
    handleFullScreen() {
      Util.toggleFullScreen();
    },
    handleLogut() {
      this.$router.push({ name: 'login-sair' });
    },

    abrirConfiguracoesDoTema() {
      this.toggleDrawerThemeAction(true);
    },
  },
};
</script>

<style lang="sass" scoped>
  .toolbar-logo
    display: flex
    padding: 5px
    margin-left: -18px !important
    width: 258px
    height: 64px
    position: relative
    @media #{map-get($display-breakpoints, 'sm-and-down')}
      height: 56px
      width: 122px
      margin-left: -17px !important

    .button-drawer
      position: absolute
      top: 10px
      right: -28px
      @media #{map-get($display-breakpoints, 'sm-and-down')}
        .button-drawer
          top: 4px

  .toolbar-logo
    img
      margin: 10px 15px
      height: 36px
      @media #{map-get($display-breakpoints, 'sm-and-down')}
        height: 28px
        margin-top: 10px !important

</style>
