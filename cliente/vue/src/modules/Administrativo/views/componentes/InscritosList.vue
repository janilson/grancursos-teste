<template>
  <v-container
    fluid
  >

    <v-row>
      <v-col>
        <download-arquivos
          :action-export="downloadInscritos"
          :filtro="filtroInscritosMunicipioGetter || {}"
          :lista="itens"
        ></download-arquivos>
      </v-col>
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64" class="primary--text"></v-progress-circular>
      </v-overlay>
    </v-row>
    <v-row
      row
      wrap
    >
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
              class="elevation-1"
              item-key="co_inscritos"
            >
              <template v-slot:item.nu_pontuacao_total="{ item }">
                <span
                  style="cursor:pointer;"
                  title="Clique aqui para ver o formulário de inscrição"
                  @click="mostrarGrupos(item,

			                  )"
                >
                  {{ item.nu_pontuacao_total }}
                </span>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <modal-visualizar-grupos :dadosEnvio="dadosEnvioModal" v-model="dialogVisualizarGrupos"
                             :grupos="grupos"
                             :nuPontuacaoTotal="nuPontuacaoTotal"/>
  </v-container>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import ModalVisualizarGrupos from "./ModalVisualizarGrupos";
    import DownloadArquivos from "../../../shared/components/DownloadArquivos";

    export default {
        name: "InscritosList",
        components: {DownloadArquivos, ModalVisualizarGrupos},
        data() {
            return {
                overlay: false,
                loading: false,
                stopWatch:false,
                nuPontuacaoTotal: 0,
                grupos: [],
                dadosEnvioModal: {},
                dialogVisualizarGrupos: false,
                noDataText: 'Não foi localizado município inscrito!',
                totalItems: 10,
                options: {
                    page: 1,
                    itemsPerPage: 10,
                    sortBy: [],
                    sortDesc: []
                },
                headers: [
                    {
                        text: 'Município',
                        value: 'no_municipio',
                        sortable: true
                    },
                    {
                        text: 'UF',
                        value: 'no_uf',
                        sortable: true
                    },
                    {
                        text: 'Região',
                        value: 'no_regiao',
                        sortable: true
                    },
                    {
                        text: 'Grupo Municipal',
                        value: 'tp_grupo_municipio',
                        sortable: true
                    },
                    {
                        text: 'População',
                        value: 'nu_populacao',
                        sortable: true
                    },
                    {
                        text: 'Pontuação',
                        value: 'nu_pontuacao_total',
                        sortable: true
                    }
                ],
                itens: []
            }
        },
        mounted() {
            this.limparFiltroInscritos();
        },

        watch: {
            inscritosGetter(data) {
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
                    const options = {
                        page: value.page,
                        per_page: value.itemsPerPage,
                        order_by: value.sortBy[0],
                        sort_desc: value.sortDesc[0],
                    };

                    const filtro = this.filtroInscritosMunicipioGetter;
                    const params = {...filtro, ...options};

                    if (this.stopWatch) {
                        this.stopWatch = false;
                        return value;
                    }

                    this.loading = true;
                    this.listarInscritos(params)
                        .finally(() => this.loading = false);
                },
                deep: true,
            }
        },
        computed: {
            ...mapGetters({
                inscritosGetter: 'Administrativo/inscritosMunicipio',
                filtroInscritosMunicipioGetter: 'Administrativo/filtroInscritosMunicipio'
            }),
        },
        methods: {
            ...mapActions({
                downloadInscritos: 'Administrativo/downloadInscritos',
                listarInscritos: 'Administrativo/listarInscritos',
                recuperarGrupos: 'Inscricao/recuperarGrupos',
                limparFiltroInscritos: 'Administrativo/limparFiltroInscritos',
            }),
            mostrarGrupos(item) {
                const coAdesao = item.co_adesao;
                const noUsuarioEnvio = item.no_usuario_envio;
                const dsEmailEnvio = item.dh_envio;
                const dhEnvio = item.dh_envio;
                const nuCpfEnvio = item.nu_cpf_envio;
                const noMunicipio = item.no_municipio;
                const sgUf = item.no_uf;
                const nuPontuacaoTotal = item.nu_pontuacao_total;
                const data = (dhEnvio).split(' ');
                const coArquivo = item.pre_requisito_arquivo.co_arquivo;
                const noArquivo = item.pre_requisito_arquivo.no_arquivo;

                this.nuPontuacaoTotal = nuPontuacaoTotal;
                this.recuperarGrupos(coAdesao)
                    .then((response) => {
                        this.sanitizarDadosGrupo(response)
                            .then(() => {
                                this.dadosEnvioModal = {
                                    noUsuarioEnvio: noUsuarioEnvio,
                                    dsEmailEnvio: dsEmailEnvio,
                                    dhEnvio: dhEnvio,
                                    dtEnvio: data[0],
                                    hrEnvio: data[1],
                                    nuCpfEnvio: nuCpfEnvio,
                                    noMunicipio: noMunicipio,
                                    sgUf: sgUf,
                                    coArquivo: coArquivo,
                                    noArquivo: noArquivo
                                };
                                this.dialogVisualizarGrupos = true;
                            });
                    });
            },
            async sanitizarDadosGrupo(dados) {
                let arrGrupos = [];
                dados.data.forEach(grupo => {
                    let perguntas = [];
                    let countPergunta = 0;
                    grupo.itens.forEach(item => {
                        let objItem = {
                            co_formulario_item_inscricao: item.co_formulario_item_inscricao,
                            co_formulario_resposta: item.co_formulario_resposta,
                            label: item.ds_formulario_item_inscricao,
                            value: item.co_formulario_item_inscricao,
                            st_resposta: item.st_resposta,
                            nu_pontuacao: item.nu_pontuacao,
                            tp_item: item.tp_formulario_item_inscricao,
                            disabled: true
                        };

                        if (item.tp_formulario_item_inscricao === 'P') {
                            objItem.cod = countPergunta;
                            countPergunta++;
                        }
                        perguntas.push(objItem);
                    });

                    arrGrupos[grupo.co_grupo] = {
                        nu_pontuacao_total: grupo.nu_pontuacao_total,
                        ds_grupo: grupo.ds_grupo,
                        co_grupo: grupo.co_grupo,
                        perguntas: perguntas,
                        disabled: true
                    };
                });

                this.grupos = arrGrupos;
            }
        }
    }
</script>

<style scoped>

</style>
