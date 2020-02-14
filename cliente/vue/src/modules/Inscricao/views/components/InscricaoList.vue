<template>
  <v-container
    fluid
  >
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
              :items="inscricoesGetter"
              :loading="loading"
              :options.sync="options"
              class="elevation-1"
              item-key="co_adesao"
            >
              <template v-slot:item.nu_cpf_envio="{ item }">
                {{ item.nu_cpf_envio | mxFiltroFormatarCPFCNPJ }}
              </template>
              <template v-slot:item.action="{ item }">
                <v-btn
                  :disabled="!item.existe_envio"
                  @click="visualizarInscricao(item)"
                  class="mr-1"
                  color="secondary"
                  dark
                  depressed
                  icon
                  outlined
                  title="Visualizar Inscrição"
                >
                  <v-icon small>{{ item.existe_envio ? 'remove_red_eye' : 'visibility_off' }}
                  </v-icon>
                </v-btn>
                <v-btn
                  @click="editarItemModal(item)"
                  class="mr-1"
                  color="primary"
                  dark
                  depressed
                  icon
                  outlined
                  title="Editar Inscrição"
                >
                  <v-icon small>edit</v-icon>
                </v-btn>
              </template>
            </v-data-table>

            <modal-nova-inscricao
              :download-resumo="downloadResumo"
              :enviar-pre-requisito="enviarPreRequisito"
              :enviar-inscricao="enviarInscricao"
              :grupos="grupos || []"
              :handleGrupo="handleGrupo"
              :inscricao="inscricaoSelecionada"
              :isLoadingGrupo="isLoadingGrupo"
              :listar="listar"
              v-model="dialog"
              :edit="true"
            />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';
  import MxFilters from '@/modules/shared/mixins/filters';
  import ModalNovaInscricao from "./ModalNovaInscricao";

  export default {
    name: 'Inscrição',
    mixins: [MxFilters],
    components: {ModalNovaInscricao},
    data() {
      return {
        bloqueado: false,
        grupos: [],
        dialog: false,
        grupoAtual: '0',
        loading: false,
        coAdesao: null,
        isLoadingGrupo: true,
        inscricaoSelecionada: {},
        options: {
          page: 1,
          rowsPerPage: 10,
        },
        itens: [],
        totalItems: 0,
        filtros: {},
        mostrarFiltros: false,
        mostrarModalEdicao: false,
        mostrarModalAlterarStatus: false,
        mostrarModalExclusao: false,
        itemEmEdicao: {},
        headers: [
          {
            text: 'Inscrição',
            value: 'no_municipio',
            sortable: true
          },
          {
            text: 'UF',
            value: 'no_uf',
            sortable: true
          },
          {
            text: 'Situação',
            value: 'ds_situacao',
            sortable: true
          },
          {
            text: 'Enviado por',
            value: 'no_usuario_envio',
            sortable: true
          },
          {
            text: 'CPF',
            value: 'nu_cpf_envio',
            sortable: true
          },
          {
            text: 'Ações',
            sortable: false,
            value: 'action',
          },
        ],
      };
    },
    created() {
      this.listar();
    },
    computed: {
      ...mapGetters({
        inscricoesGetter: 'Inscricao/inscricoes',
        grupoGetter: 'Inscricao/grupos',
        usuarioLogadoGetter: 'app/usuarioLogado'
      }),
    },
    methods: {
      ...mapActions({
        listarInscricoes: 'Inscricao/listarInscricao',
        recuperarGrupos: 'Inscricao/recuperarGrupos',
        salvarInscricao: 'Inscricao/enviarInscricao',
        definirMensagemSucesso: 'app/setMensagemSucesso',
        atualizarDadosGrupo: 'Inscricao/atualizarDadosGrupo',
        downloadPdf: 'Inscricao/downloadPdf',
        downloadResumoAction: 'Inscricao/downloadResumo',
        verificaBloqueio: 'Inscricao/verificaBloqueio',
        mensagemErro: 'app/setMensagemErro',
        enviarPreRequisitoAction : 'Inscricao/enviarPreRequisito'
      }),
      async downloadResumo() {
          return await this.downloadResumoAction(this.coAdesao);
      },
      async enviarPreRequisito(preRequisito) {
        this.isLoadingGrupo = true;
        preRequisito.co_adesao = this.coAdesao;
        preRequisito.co_grupo = 0;
        await this.enviarPreRequisitoAction(preRequisito).then((response) => {
          this.inscricaoSelecionada.hasPreRequisito = true;
          return true;
        }).finally(() => {
          this.isLoadingGrupo = false;
        });
      },
      listar() {
        this.loading = true;
        this.listarInscricoes()
          .then(data => this.itens = data)
          .finally(() => this.loading = false);
      },
      enviarInscricao() {
        this.handleGrupo(9)
          .then(() => {
            this.salvarInscricao(this.coAdesao)
              .then(response => {
                this.definirMensagemSucesso(response.message);
                this.dialog = false;
                this.listar();
              })
          });
      },
      editarItemModal(item) {
        const hasPreRequisito = item.has_pre_requisito;
        const preRequisitoArquivo = item.pre_requisito_arquivo;
        const label = `${item.no_municipio} - ${item.no_uf}`;
        const labelStatus = item.existe_envio ? 'Enviado' : 'Pendente';
        const status = item.existe_envio;
        const cpfEnvio = item.nu_cpf_envio;
        const nomeEnvio = item.no_usuario_envio;
        const emailEnvio = item.ds_email_envio;
        const dhEnvio = (item.dh_envio).split(' ');

        const nome = this.usuarioLogadoGetter.no_usuario;
        const email = this.usuarioLogadoGetter.ds_email;
        const cpf = this.usuarioLogadoGetter.nu_cpf;

        this.inscricaoSelecionada = {
          label: label,
          labelStatus: labelStatus,
          status: status,
          cpfEnvio: cpfEnvio,
          nomeEnvio: nomeEnvio,
          emailEnvio: emailEnvio,
          dtEnvio: dhEnvio[0],
          hrEnvio: dhEnvio[1],
          nome: nome,
          email: email,
          cpf: cpf,
          hasPreRequisito : hasPreRequisito,
          arquivo: preRequisitoArquivo
        };

        this.coAdesao = item.co_adesao;

        this.estaBloqueado(this.coAdesao)
          .then((data) => {

            this.bloqueado = data !== undefined
              && parseInt(data.co_usuario, 10) !== parseInt(this.usuarioLogadoGetter.co_usuario, 10);
            return data;
          })
          .then((data) => {
            if (this.bloqueado) {
              this.mensagemErro(`A inscrição esta bloqueada por ${data.usuario.no_usuario}`);
              return false;
            }

            this.isLoadingGrupo = true;
            this.recuperarGrupos(this.coAdesao).then((response) => {
              let arrGrupos = [];
              response.data.forEach(grupo => {
                let perguntas = [];
                let countPergunta = 0;

                grupo.itens.forEach((item) => {
                  let objItem = {
                    co_formulario_item_inscricao: item.co_formulario_item_inscricao,
                    co_formulario_resposta: item.co_formulario_resposta,
                    label: item.ds_formulario_item_inscricao,
                    value: item.co_formulario_item_inscricao,
                    st_resposta: item.st_resposta,
                    nu_pontuacao: item.nu_pontuacao,
                    tp_item: item.tp_formulario_item_inscricao
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
                  perguntas: perguntas
                };
              });

              this.grupos = arrGrupos;
              this.dialog = true;
              this.isLoadingGrupo = false;
            });

          });
      },
      async handleGrupo(coGrupo, firstTime) {
        this.isLoadingGrupo = true;

        let inCache = false;
        let grupos = Object.values(this.grupos);

        if (!inCache) {
          this.recuperarGrupos(this.coAdesao).then(() => {
            this.isLoadingGrupo = false;
          });
        }

        if (!firstTime) {
          await this.montarDadosGrupo(grupos[this.grupoAtual], this.grupoAtual);
        }

        this.grupoAtual = coGrupo;

        return true;
      },
      async estaBloqueado(coAdesao) {
        return await this.verificaBloqueio(coAdesao);
      },
      async montarDadosGrupo(grupo, coGrupo) {
        let dadosPerguntas = [];

        if ((grupo || {}).perguntas) {
          grupo.perguntas.forEach(pergunta => {
            if (pergunta.value && pergunta.tp_item !== 'P') {
              dadosPerguntas.push({
                co_formulario_resposta: pergunta.co_formulario_resposta,
                st_resposta: pergunta.st_resposta ? 1 : 0
              });
            }
          });

        }

        let dadosGrupo = {
          co_grupo: coGrupo,
          co_adesao: this.coAdesao,
          payload: dadosPerguntas
        };

        this.inscricaoSelecionada.status = false;
        this.inscricaoSelecionada.labelStatus = 'Pendente';

        return await this.atualizarDadosGrupo(dadosGrupo);
      },
      visualizarInscricao(adesao) {
        this.downloadPdf(adesao.co_adesao);
      }
    },
    watch: {
      dialog(val) {
        if (!val) {
          this.grupoAtual = 0;
          // this.grupos = [];
          this.listarInscricoes();
        }
      }
    },
  };
</script>
