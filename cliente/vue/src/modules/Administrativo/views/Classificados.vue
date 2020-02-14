<template>
  <v-container>
    <v-container fluid>
      <v-form
        ref="form"
      >
        <v-row>
          <v-col
            cols="12"
            md="4"
          >
            <v-select
              :items="gruposMunicipais"
              item-text="label"
              item-value="value"
              label="Grupo Municipal"
              v-model="formulario.tp_grupo_municipio"
            />
          </v-col>

          <v-col
            cols="12"
            md="4"
          >
            <v-select
              :items="classificacoes"
              item-text="label"
              item-value="value"
              label="Classificação"
              v-model="formulario.nu_classificacao"
            />
          </v-col>
          <v-col
            class="mt-4"
            cols="12"
            md="4"
          >
            <v-btn
              color="secondary"
              class="mr-4 mb-1 float-right"
              @click="reset"
            >
              Limpar Filtro
            </v-btn>

            <v-btn
              @click="filtrarClassificados"
              color="primary"
              class="mr-4 float-right"
            >Aplicar Filtro
            </v-btn>
          </v-col>
        </v-row>
      </v-form>

      <v-row>
        <v-col
          cols="12"
          md="12"
        >
        <span class="float-right mt-4" v-if="loadingAprovarRelacao"><v-progress-circular
          indeterminate color="primary"/></span>
          <v-btn v-else class="mt-4 float-right" color="primary"
                 @click="modalConfirmacaoAprovar = true">
            <span>Aprovar Classificados</span>
          </v-btn>
        </v-col>
      </v-row>

      <v-row>
        <v-col>
          <download-arquivos
            :action-export="downloadClassificados"
            :filtro="filtroClassificadosGetter || {}"
            :lista="itens"
          ></download-arquivos>
        </v-col>
        <v-overlay :value="overlay">
          <v-progress-circular indeterminate size="64" class="primary--text"></v-progress-circular>
        </v-overlay>
      </v-row>

      <v-row>
        <v-col>
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
            item-key="no_municipio"
          >

            <template v-slot:item.no_municipio="{ item }">
		                <span
                      @click="mostrarItem(item.servidores)"
                      style="cursor:pointer;"
                      title="Clique aqui para ver os representantes"
                    >
		                  {{ item.no_municipio }}
		                </span>
            </template>

            <template v-slot:item.nu_pontuacao_total="{ item }">
		                <span
                      @click="mostrarGrupos(item)"
                      style="cursor:pointer;"
                      title="Clique aqui para ver o formulário de inscrição">
		                  {{ item.nu_pontuacao_total }}
		                </span>
            </template>

            <template v-slot:item.st_adesao_quali="{ item }">
              <v-checkbox
                :key="item.co_adesao"
                :value="item.st_adesao_quali"
                @change="enviarAdesao(item, 'st_adesao_quali')"
                v-model="item.st_adesao_quali"
              />
            </template>

            <template v-slot:item.st_pcf_quali="{ item }">
              <v-checkbox
                :key="item.co_adesao"
                :value="item.st_pcf_quali"
                @change="enviarAdesao(item, 'st_pcf_quali')"
                class=""
                v-model="item.st_pcf_quali"
              />
            </template>

            <template v-slot:item.st_progredir_quali="{ item }">
              <v-checkbox
                :key="item.co_adesao"
                :value="item.st_progredir_quali"
                @change="enviarAdesao(item, 'st_progredir_quali')"
                v-model="item.st_progredir_quali"
              />
            </template>

            <template v-slot:item.st_paa_quali="{ item }">
              <v-checkbox
                :key="item.co_adesao"
                :value="item.st_paa_quali"
                @change="enviarAdesao(item, 'st_paa_quali')"
                v-model="item.st_paa_quali"
              />
            </template>

            <template v-slot:item.st_senapredi_quali="{ item }">
              <v-checkbox
                :key="item.co_adesao"
                :value="item.st_senapredi_quali"
                @change="enviarAdesao(item, 'st_senapredi_quali')"
                v-model="item.st_senapredi_quali"
              />
            </template>
          </v-data-table>

          <v-dialog
            max-width="960"
            v-model="dialog"
          >
            <v-card>
              <v-card-title class="headline">
                <b class="green--text display-1">Representantes</b>
              </v-card-title>

              <v-card-text>
                <v-row>
                  <v-col cols="4" v-for="item in dialogModal">
                    <v-text-field :value="(item || {}).nu_cpf" disabled label="CPF"/>
                    <v-text-field :value="(item || {}).no_servidor" disabled label="Nome"/>
                    <v-text-field :value="(item || {}).ds_email" disabled label="E-mail"/>
                    <v-text-field :value="(item || {}).nu_telefone" disabled label="Telefone"/>
                    <v-text-field :value="(item || {}).no_funcao" disabled label="Cargo/Função"/>
                    <v-text-field :value="(item || {}).no_lotacao" disabled
                                  label="Unidade de lotação"/>
                  </v-col>
                </v-row>
              </v-card-text>

              <v-card-actions>
                <v-spacer/>
                <v-btn
                  @click="dialog = false"
                  color="green darken-1"
                  text
                >
                  Fechar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>

      <modal-visualizar-grupos
        :dadosEnvio="dadosEnvioModal"
        :grupos="grupos"
        :nuPontuacaoTotal="nuPontuacaoTotal"
        v-model="dialogVisualizarGrupos"
      />

      <v-dialog
        v-model="modalConfirmacaoAprovar"
        max-width="360"
      >
        <v-card>
          <v-card-title class="headline">
            Aprovar Classificados
          </v-card-title>

          <v-card-text>
            Confirma o envio da classificação?
          </v-card-text>

          <v-card-actions>
            <v-spacer/>

            <v-btn
              color="red darken-1"
              text
              @click="modalConfirmacaoAprovar = false"
            >
              Não
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              @click="aprovarRelacao"
            >
              Sim
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-container>
  </v-container>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';
    import ModalVisualizarGrupos from "./componentes/ModalVisualizarGrupos";
    import DownloadArquivos from "../../shared/components/DownloadArquivos";

    export default {
        name: "Classificados",
        components: {DownloadArquivos, ModalVisualizarGrupos},
        data() {
            return {
                overlay: false,
                loading: false,
                stopWatch: false,
                noDataText: 'Não foi localizado nenhum classificado!',
                loadingAprovarRelacao: false,
                modalConfirmacaoAprovar: false,
                nuPontuacaoTotal: 0,
                grupos: [],
                dadosEnvioModal: {},
                dialog: false,
                dialogVisualizarGrupos: false,
                dialogModal: [],
                totalItems: 10,
                options: {
                    page: 1,
                    itemsPerPage: 10,
                    sortBy: [],
                    sortDesc: []
                },
                headers: [
                    {text: 'Município', value: 'no_municipio', sortable: true},
                    {text: 'UF', value: 'sg_uf', sortable: true},
                    {text: 'Grupo Municipal', value: 'ds_grupo_municipio', sortable: true},
                    {text: 'Pontuação', value: 'nu_pontuacao_total', sortable: true},
                    {text: 'Classificação', value: 'nu_classificacao', sortable: true},
                    {text: 'Adesão', value: 'st_adesao_quali', sortable: true},
                    {text: 'PCF', value: 'st_pcf_quali', sortable: true},
                    {text: 'Progredir', value: 'st_progredir_quali', sortable: true},
                    {text: 'PAA', value: 'st_paa_quali', sortable: true},
                    {text: 'Senapredi', value: 'st_senapredi_quali', sortable: true},
                    {text: 'Situação', value: '', sortable: false},
                ],
                checkAcao: [
                    'st_adesao_quali',
                    'st_pcf_quali',
                    'st_progredir_quali',
                    'st_paa_quali',
                    'st_senapredi_quali'
                ],
                itens: [],
                grupoMunicipal: '',
                classificacao: '',
                gruposMunicipais: [
                    {label: 'Grupo I - Com até 20.000 habitantes', value: 1},
                    {label: 'Grupo II - De 20.001 até 50.000 habitantes', value: 2},
                    {label: 'Grupo III - De 50.001 até 100.000 habitante', value: 3},
                    {label: 'Grupo IV - De 100.001 até 500.000 habitantes', value: 4},
                    {label: 'Grupo V - Com mais de 500.000 habitantes', value: 5},
                ],
                classificacoes: [
                    {label: '1º lugar', value: 1},
                    {label: '2º lugar', value: 2},
                    {label: '3º lugar', value: 3},
                    {label: 'Outros', value: 4},
                ],
                formulario: {
                    tp_grupo_municipio: '',
                    nu_classificacao: ''
                }
            }
        },
        mounted() {
            this.limparFiltroClassificados();
        },
        computed: {
            ...mapGetters({
                classificadosGetter: 'Administrativo/classificados',
                filtroClassificadosGetter: 'Administrativo/filtroClassificados'
            }),
        },
        watch: {
            classificadosGetter(data) {
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

                    const filtro = this.filtroClassificadosGetter;
                    const params = {...filtro, ...options};

                    if (this.stopWatch) {
                        this.stopWatch = false;
                        return value;
                    }

                    this.loading = true;
                    this.listarClassificadosAction(params)
                        .finally(() => this.loading = false);
                },
                deep: true,
            }
        },
        methods: {
            ...mapActions({
                listarClassificadosAction: 'Administrativo/listarClassificados',
                recuperarGrupos: 'Inscricao/recuperarGrupos',
                aprovarRelacaoClassificados: 'Administrativo/aprovarRelatorio',
                definirMensagemSucesso: 'app/setMensagemSucesso',
                limparClassificados: 'Administrativo/limparClassificados',
                limparFiltroClassificados: 'Administrativo/limparFiltroClassificados',
                downloadClassificados: 'Administrativo/downloadClassificados',
                atualizarAdesao: 'Administrativo/atualizarAdesao'
            }),
            enviarAdesao(item, campo) {
                let adesao = {co_adesao: item.co_adesao};
                adesao[campo] = item[campo] === null ? 0 : 1;
                this.atualizarAdesao(adesao);
            },
            aprovarRelacao() {
                this.loadingAprovarRelacao = true;
                this.modalConfirmacaoAprovar = false;

                this.aprovarRelacaoClassificados()
                    .then(response => {
                        this.definirMensagemSucesso(response.message);
                        this.loadingAprovarRelacao = false;
                    });
            },
            mostrarGrupos(item) {
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

                this.dialogVisualizarGrupos = true;
                this.nuPontuacaoTotal = nuPontuacaoTotal;
                this.sanitizarDadosGrupo(item.grupos).then(() => {
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
                });
            },
            async sanitizarDadosGrupo(dados) {
                let arrGrupos = [];
                dados.forEach(grupo => {
                    let perguntas = [];
                    let countPergunta = 0;
                    grupo.itens.forEach(items => {
                        items.forEach(item => {
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

                        })
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
            },
            reset() {
                this.$refs.form.reset();
                this.limparClassificados();
                this.limparFiltroClassificados();
            },
            mostrarItem(item) {
                this.dialogModal = item;
                this.dialog = true;
            },
            filtrarClassificados() {
                if (!this.$refs.form.validate()) {
                    return false;
                }
                let formulario = {...this.formulario};
                Object.keys(formulario).forEach((key) => formulario[key] !== '' || delete formulario[key]);
                const filtro = this.filtroClassificadosGetter;

                const params = {...filtro, ...formulario};
                delete params.filtro;

                params.page = 1;

                this.listarClassificadosAction(params);
            }
        }
    }
</script>

<style scoped>

</style>
