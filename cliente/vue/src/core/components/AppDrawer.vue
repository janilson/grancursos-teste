<template>
  <v-navigation-drawer
    :value="primaryDrawerGetter.model"
    :clipped="primaryDrawerGetter.clipped"
    :floating="primaryDrawerGetter.floating"
    :mini-variant="primaryDrawerGetter.mini"
    :permanent="primaryDrawerGetter.type === 'permanent'"
    :temporary="primaryDrawerGetter.type === 'temporary'"
    hide-overlay
    app
    @input="toggleStatusPrimaryDrawer($event)"
  >
    <vue-perfect-scrollbar
      class="drawer-menu--scroll"
      :settings="scrollSettings"
    >
      <template v-for="item in menus">
        <v-list-item
          v-if="item.perfil == null || usuarioLogadoGetter.tp_perfil == item.perfil"
          :key="item.no_funcionalidade"
          :to="!item.href ? { name: item.no_rota } : null"
          :href="item.href"
          :disabled="item.disabled"
          :target="item.target"
          :title="item.no_funcionalidade"
          rel="noopener"
          link
        >
          <v-list-item-action v-if="item.no_icone">
            <v-icon>{{ item.no_icone }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.no_funcionalidade }}</v-list-item-title>
          </v-list-item-content>
          <v-list-item-action v-if="item.subAction">
            <v-icon class="success--text">
              {{ item.subAction }}
            </v-icon>
          </v-list-item-action>
        </v-list-item>
      </template>
    </vue-perfect-scrollbar>
  </v-navigation-drawer>
</template>
<script>
    import VuePerfectScrollbar from 'vue-perfect-scrollbar';
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: 'AppDrawer',
        components: {
            VuePerfectScrollbar,
        },
        data() {
            return {
                menus: [
                    {
                        no_funcionalidade: 'Adesões',
                        no_icone: 'assignment',
                        no_rota: 'lista-adesoes',
                        perfil: 'I'
                    },
                    {
                        no_funcionalidade: 'Inscrições',
                        no_icone: 'assignment_ind',
                        no_rota: 'lista-inscritos',
                        perfil: 'I'
                    },
                    {
                        no_funcionalidade: 'Classificados',
                        no_icone: 'emoji_events',
                        no_rota: 'lista-classificados',
                        perfil: 'I'
                    },
                    {
                        no_funcionalidade: 'Representantes',
                        no_icone: 'people',
                        no_rota: 'lista-representantes',
                        perfil: 'I'
                    },
                    {
                        no_funcionalidade: 'Minhas Inscrições',
                        no_icone: 'list',
                        no_rota: 'lista-inscricao',
                        perfil: 'E'
                    },
                    {
                        no_funcionalidade: 'Históricos',
                        no_icone: 'history',
                        no_rota: 'lista-historico',
                        perfil: null
                    }
                ],
                scrollSettings: {
                    maxScrollbarLength: 160,
                },
            };
        },
        computed: {
            ...mapGetters({
                usuarioLogadoGetter: 'app/usuarioLogado',
                primaryDrawerGetter: 'app/primaryDrawer',
            }),
            computeGroupActive() {
                return true;
            },
            sideToolbarColor() {
                return this.$vuetify.options.extra.sideNav;
            },
            drawer: {
                get() {
                    return Object.assign({}, this.primaryDrawer);
                },
                set(value) {
                    this.setPrimaryDrawerAction(value);
                },
            },
        },
        mounted() {
            if (this.$vuetify.breakpoint.mdAndDown) {
                this.setPrimaryDrawerStatus(false);
            }
        },
        methods: {
            ...mapActions({
                setPrimaryDrawerStatus: 'app/setPrimaryDrawerStatus',
            }),
            toggleStatusPrimaryDrawer(status) {
                this.setPrimaryDrawerStatus(status);
            },
        },
    };
</script>

<style lang="sass" scoped>
  .app--drawer
    overflow: hidden

    .drawer-menu--scroll
      height: calc(100% - 60px)
      overflow: auto
</style>
