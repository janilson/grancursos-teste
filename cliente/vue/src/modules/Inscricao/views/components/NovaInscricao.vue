<template>
	<v-container>
		<v-row>
			<v-col
				cols="12"
				md="3"
			>
				<v-form
					lazy-validation
					ref="form"
					v-model="isFormValid"
				>
					<v-select
						:items="listaAdesoes"
						:return-object="true"
						:rules="[rules.required]"
						@change="selecionarInscricao"
						item-text="label"
						item-value="value"
						label="Selecione o Município"
						required
						return-object
					/>
				</v-form>

			</v-col>
			<v-col
				class="mt-4"
				cols="12"
				md="3"
			>
				<v-btn @click="iniciarInscricao" color="primary">Iniciar inscrição</v-btn>
				<modal-nova-inscricao
					:download-resumo="downloadResumo"
					:enviar-pre-requisito="enviarPreRequisito"
					:enviar-inscricao="enviarInscricao"
					:grupos="grupos"
					:handleGrupo="handleGrupo"
					:inscricao="inscricaoSelecionada"
					:isLoadingGrupo="isLoadingGrupo"
					:listar="listar"
					v-model="dialog"
					:edit="false"
				/>
			</v-col>
		</v-row>

	</v-container>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';
  import ModalNovaInscricao from "./ModalNovaInscricao";
  import CardCarregando from '@/core/components/card/CardCarregando';

  export default {
    name: 'NovaInscricao',
    components: {
      ModalNovaInscricao,
      CardCarregando,
    },
    data: () => ({
      grupos: [],
      grupoAtual: 1,
      isFormValid: false,
      appTitle: process.env.VUE_APP_TITLE,
      loading: true,
      coAdesao: null,
      inscricaoSelecionada: {},
      dialog: false,
      listaAdesoes: [],
      isLoadingGrupo: true,
      rules: {
        required: v => !!v || "Campo não preenchido",
      }

    }),
    methods: {
      enviarInscricao() {
        this.handleGrupo(9).then(() => {
          this.salvarInscricao(this.coAdesao).then(response => {
            this.definirMensagemSucesso(response.message);
            this.dialog = false;
            this.isLoadingGrupo = false;
            this.listar();
          })
        });
      },
      listar() {
        this.loading = true;
        this.listarInscricoes()
          .then(data => this.itens = data)
          .finally(() => {
            this.loading = false;
            this.isLoadingGrupo = false;
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
      },
      iniciarInscricao() {
        if (!this.$refs.form.validate()) {
          return false;
        }

        this.isLoadingGrupo = true;
        this.iniciar(this.coAdesao)
          .then(() => {
              this.recuperarGrupos(this.coAdesao).then((response) => {
                this.sanitizarDadosGrupo(response).then(() => {
                  this.obterAdesoes();
                  this.dialog = true;
                  this.isLoadingGrupo = false;
                });
              });
            }
          );
      },
      async handleGrupo(coGrupo, firstTime) {
        this.isLoadingGrupo = true;

        let grupos = Object.values(this.grupos);

        if (!firstTime) {
          await this.montarDadosGrupo(grupos[this.grupoAtual], this.grupoAtual);
        }

        this.grupoAtual = coGrupo;

        return true;
      },
      async montarDadosGrupo(grupo, coGrupo) {
        let dadosPerguntas = [];

        if ((grupo || {}).perguntas) {
          grupo.perguntas.forEach(pergunta => {
            if (pergunta.value) {
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

        this.isLoadingGrupo = false;

        return await this.atualizarDadosGrupo(dadosGrupo);
      },
      selecionarInscricao(inscricao) {
        const label = inscricao.label;
        const labelStatus = 'Pendente';
        const status = false;
        const nome = this.usuarioLogadoGetter.no_usuario;
        const email = this.usuarioLogadoGetter.ds_email;
        const cpf = this.usuarioLogadoGetter.nu_cpf;

        this.inscricaoSelecionada = {
          label: label,
          labelStatus: labelStatus,
          status: status,
          nome: nome,
          email: email,
          cpf: cpf,
          hasPreRequisito: false,
        };

        this.coAdesao = inscricao.value;
      },
      ...mapActions({
        listarAdesoes: 'Inscricao/listarAdesoes',
        listarInscricoes: 'Inscricao/listarInscricao',
        recuperarGrupos: 'Inscricao/recuperarGrupos',
        iniciar: 'Inscricao/iniciarInscricao',
        atualizarDadosGrupo: 'Inscricao/atualizarDadosGrupo',
        salvarInscricao: 'Inscricao/enviarInscricao',
        definirMensagemSucesso: 'app/setMensagemSucesso',
        enviarPreRequisitoAction: "Inscricao/enviarPreRequisito",
        downloadResumoAction: 'Inscricao/downloadResumo',
      }),
      async downloadResumo() {
        return await this.downloadResumoAction(this.coAdesao);
      },
      async enviarPreRequisito(preRequisito) {
        this.loading = true;
        preRequisito.co_adesao = this.coAdesao;
        preRequisito.co_grupo = 0;
        return await this.enviarPreRequisitoAction(preRequisito).then((response) => {
          this.inscricaoSelecionada.hasPreRequisito = true;
          return true;
        }).finally(() => {
          this.loading = false;
        });
      },
      obterAdesoes() {
        this.listarAdesoes().then(() => {
          this.listaAdesoes = this.adesoesGetter;
        });
      },
    },
    computed: {
      ...mapGetters({
        adesoesGetter: 'Inscricao/adesoes',
        gruposGetter: 'Inscricao/grupos',
        usuarioLogadoGetter: 'app/usuarioLogado'
      }),
    },
    watch: {
      dialog(val) {
        if (!val) {
          // this.grupos = [];
          this.obterAdesoes();
        }
      }
    },
    mounted() {
      this.obterAdesoes();
    }
  };
</script>
