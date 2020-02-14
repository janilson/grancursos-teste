<template>
  <v-container
    fluid
  >
    <v-row
      row
      wrap
    >
      <v-row
        class="">
        <v-col lg="12" class="text-right">
          <download-arquivos
            :action-export="downloadHistorico"
            :filtro="filtroHistoricosGetter || {}"
            :lista="itens"
          ></download-arquivos>
        </v-col>
        <v-overlay :value="overlay">
          <v-progress-circular indeterminate size="64" class="primary--text"></v-progress-circular>
        </v-overlay>
      </v-row>

      <v-col lg="12">
        <v-card>
          <v-divider/>

          <v-card-text class="pa-0">
            <v-data-table
              :headers="headers"
              :items="itens"
              :loading="loading"
              :no-data-text="noDataText"
              :options.sync="options"
              :items-per-page="options.itemsPerPage"
              :server-items-length="totalItems"
              :footer-props="{
                'items-per-page-options': [10, 20, 30, 40, 50]
              }"
              item-key="co_resposta_historico"
              class="elevation-1"
            >

              <template v-slot:item.ds_item="{ item }">
                <span
                  style="cursor:pointer;"
                  title="Clique aqui para ver o item"
                  @click="mostrarItem(item)"
                >
                  {{ item.ds_item }}
                </span>
              </template>
              <template v-slot:item.st_resposta_antiga="{ item }">
                <div v-if="item.st_resposta_antiga">
                  Marcado
                </div>
                <div v-else>
                  Desmarcado
                </div>
              </template>
              <template v-slot:item.st_resposta_atual="{ item }">
                <div v-if="item.st_resposta_atual">
                  Marcado
                </div>
                <div v-else>
                  Desmarcado
                </div>
              </template>
            </v-data-table>

            <v-dialog
              v-model="dialog"
              max-width="480"
            >
              <v-card>
                <v-card-title class="headline">
                  <b>
                    <span v-if="dialogModel.co_grupo !== 0 && dialogModel.co_grupo !== 9">Grupo {{ dialogModel.co_grupo }} - </span>
                    {{ dialogModel.ds_grupo }}
                  </b>
                </v-card-title>

                <v-card-text>
                  <v-spacer/>
                  {{ dialogModel.ds_item }}
                </v-card-text>

                <v-card-actions>
                  <v-spacer/>
                  <v-btn
                    color="green darken-1"
                    text
                    @click="fecharModal()"
                  >
                    Fechar
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>

          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import MxFilters from '@/modules/shared/mixins/filters';
    import DownloadArquivos from "../../../shared/components/DownloadArquivos";

    export default {
        name: 'Histórico',
        mixins: [MxFilters],
        components: {DownloadArquivos},
        data() {
            return {
                overlay: false,
                dialog: false,
                loading: false,
                isLoadingGrupo: true,
                stopWatch: false,
                noDataText: 'Não há dados disponíveis',
                totalItems: 10,
                options: {
                    page: 1,
                    itemsPerPage: 10,
                    sortBy: [],
                    sortDesc: []
                },
                dialogModel: {
                    co_grupo: null,
                    ds_grupo: null,
                    ds_item: null,
                    ds_item_pai: null
                },
                itens: [],
                filtros: {},
                mostrarFiltros: false,
                headers: [
                    {
                        text: 'Data',
                        value: 'dh_resposta',
                        sortable: true
                    },
                    {
                        text: 'CPF',
                        value: 'nu_cpf',
                        sortable: true
                    },
                    {
                        text: 'Nome',
                        value: 'no_usuario',
                        sortable: true
                    },
                    {
                        text: 'Grupo',
                        value: 'ds_grupo',
                        sortable: true
                    },
                    {
                        text: 'Item',
                        value: 'ds_item',
                        sortable: true
                    },
                    {
                        text: 'Anterior',
                        value: 'st_resposta_antiga',
                        sortable: true
                    },
                    {
                        text: 'Alteração',
                        value: 'st_resposta_atual',
                        sortable: true
                    }
                ],
            };
        },
        mounted() {
            this.limparFiltroHistorico();
        },
        computed: {
            ...mapGetters({
                inscricoesGetter: 'Inscricao/inscricoes',
                historicosGetter: 'Inscricao/historicos',
                filtroHistoricosGetter: 'Inscricao/filtroHistoricos'
            }),
        },
        watch: {
            historicosGetter(data) {
                let options = {
                    page: ((data || {}).meta || {}).current_page || 1,
                    itemsPerPage: this.options.itemsPerPage,
                    sortBy: this.options.sortBy,
                    sortDesc: this.options.sortDesc,
                };

                this.totalItems = ((data || {}).meta || {}).total || 0;
                this.itens = (data || {}).data || [];

                this.stopWatch = true;

                if (data.length === 0) {
                    options.itemsPerPage = 10;
                }

                this.options = options;
            },

            options: {
                handler(value) {
                    let options = {
                        page: value.page,
                        per_page: value.itemsPerPage,
                        order_by: value.sortBy[0],
                        sort_desc: value.sortDesc[0],
                    };

                    const filtro = this.filtroHistoricosGetter;
                    const params = {...filtro , ...options};

                    if (this.stopWatch) {
                        this.stopWatch = false;
                        return value;
                    }

                    if (params.co_adesao) {
                        this.loading = true;
                        this.listarHistorico(params)
                            .finally(() => this.loading = false);
                    }
                },
                deep: true,
            }
        },
        methods: {
            ...mapActions({
                downloadHistorico: 'Inscricao/downloadHistorico',
                listarHistorico: 'Inscricao/listarHistorico',
                limparFiltroHistorico: 'Inscricao/limparFiltroHistorico',
            }),
            mostrarItem(item) {
                this.dialogModel = item;
                this.dialog = true;
            },
            fecharModal() {
                this.dialogModel = {
                    co_grupo: null,
                    ds_grupo: null,
                    ds_item: null,
                    ds_item_pai: null
                };
                this.dialog = false;
            }
        }
    };
</script>
