<template>
	<v-container>
		<v-row>
			<v-col cols="10">
				<div>
					<v-tabs
						@change="switchTab"
						background-color="primary accent-4"
						center-active
						centered
						class="card"
						color="primary"
						dark
						grow
						v-model="aba"
					>
						<v-tabs-slider centered color="yellow"/>
						<v-tab disabled href='#0' title='Pré-Requisito'>Pré-Requisito</v-tab>
						<v-tab disabled href='#1' title='Grupo 1 - Esporte'>Grupo 1</v-tab>
						<v-tab disabled href='#2' title='Grupo 2 - Ações Culturais'>Grupo 2</v-tab>
						<v-tab disabled href='#3' title='Grupo 3 - Biblioteca e Leitura'>Grupo 3</v-tab>
						<v-tab disabled href='#4' title='Grupo 4 - Ações Integradas de Cidadania'>Grupo 4</v-tab>
						<v-tab disabled href='#5' title='Grupo 5 - Criança Feliz'>Grupo 5</v-tab>
						<v-tab disabled href='#6' title='Grupo 6 - Compras da Agricultura Familiar'>Grupo 6</v-tab>
						<v-tab disabled href='#7' title='Grupo 7 - Prevenção às Drogas'>Grupo 7</v-tab>
						<v-tab disabled href='#8' title='Grupo 8 - Plano Progredir'>Grupo 8</v-tab>
						<v-tab disabled href='#9' title='Extra'>Extra</v-tab>

						<v-tabs-items v-model="aba">
							<template v-if="isLoadingGrupo">
								<v-container class="text-center">
									<v-progress-circular
										:size="70"
										color="primary"
										indeterminate
									>
									</v-progress-circular>
								</v-container>
							</template>
							<v-tab-item :id="coGrupo.toString()" v-for="(grupo, coGrupo) in grupos">
								<grupo-perguntas
									:calculaPontuacao="calculaPontuacao"
									:ds-grupo="grupo.ds_grupo || ''"
									:edit="edit"
									:id-grupo="parseInt(coGrupo, 10)"
									:perguntas="((grupo || {}).perguntas || []) || []"
									:pontuacaoTotal="parseInt((grupo || {}).nu_pontuacao_total) || 0"
									:pre-requisito="!!inscricao.hasPreRequisito"
								>
									<template v-if="parseInt(coGrupo) === 0" v-slot:iniciar-inscricao>
										<v-container class="text-center">
											<div v-if="!inscricao.hasPreRequisito || !inscricao.arquivo">
												<file
													:accepted-file-types="['image/jpeg', 'image/png', 'application/pdf']"
													label-idle="Clique aqui para incluir o comprovante de realização de compras institucionais"
													ref="arquivo"
													v-model="anexo"
												/>
												<div class="mb-2 text-left  red--text font-weight-bold">São permitidos arquivos PDF, PNG e JPG com tamanho máximo de 10MB</div>

											</div>
											<v-card class="mb-4" v-else>
												<v-btn @click="alterarArquivo(inscricao)" class="float-right mr-3 mt-3"
												       fab title="Alterar arquivo" x-small>
													<v-icon>edit</v-icon>
												</v-btn>
												<v-card-text>
													{{ inscricao.arquivo.no_arquivo }}
													<v-icon
														@click="downloadArquivo(inscricao.arquivo.co_arquivo)"
														color="blue darken-4"
														right
														size="32px"
														title="Fazer o download do arquivo"
													>
														cloud_download
													</v-icon>

												</v-card-text>
											</v-card>
											<v-btn @click="iniciarInscricao" color="primary"
											       v-if="preRequisitoHabilitado">
												<span v-if="!edit">Iniciar Inscrição</span>
												<span v-else>CONFIRMAR ALTERAÇÃO DO ANEXO</span>
											</v-btn>
										</v-container>
									</template>
									<template v-if="parseInt(coGrupo) === 9" v-slot:btn-enviar>
										<v-container class="text-center">
											<v-btn @click="mostrarResumo" color="primary">Resumo da Inscrição</v-btn>
											<v-btn @click="enviarInscricao" class="ml-2" color="primary">Enviar Inscrição</v-btn>
										</v-container>
									</template>
								</grupo-perguntas>
                <v-overlay :value="overlay">
                  <v-progress-circular indeterminate size="64" class="primary--text"></v-progress-circular>
                </v-overlay>
								<v-row>
									<v-col class="text-center">
										<v-btn @click="prevTab" color="primary" v-if="coGrupo !== 0">
											Anterior
										</v-btn>
										<v-btn @click="nextTab"
										       class="ml-2"
										       color="primary"
										       v-if="proximo">
											Próximo
										</v-btn>
									</v-col>
								</v-row>

							</v-tab-item>
						</v-tabs-items>
					</v-tabs>
				</div>
			</v-col>

			<v-col cols="2">
				<v-card style="position: fixed">
					<v-card-text>
						<div class="text-center font-weight-medium red--text">Soma total de pontos:
							<div class="subheading font-weight-black" v-if="edit">{{ editar }}</div>
							<div class="subheading font-weight-black" v-else>{{ pontuacaoTotal }}</div>
						</div>
						<br/>
						<hr class="font-weight-thin primary"/>
						<br/>
						<div class="text-center font-weight-medium">
							Situação:
							<div class="subheading font-weight-black green--text" v-if="inscricao.status">
								{{ inscricao.labelStatus }}
							</div>
							<div class="subheading font-weight-black red--text" v-else>
								{{ inscricao.labelStatus }}
							</div>
						</div>
						<div class="text-left font-weight-medium" v-if="inscricao.nomeEnvio">
							<br/>
							<hr class="font-weight-thin primary"/>
							<br/>
							<div class="text-center font-weight-bold">Último Envio</div>
							<br/>
							Nome:
							<span class="subheading font-weight-black primary--text">
			                    {{ inscricao.nomeEnvio }}
			                </span>
							<br/>
							CPF:
							<span class="subheading font-weight-black primary--text">
                                {{ inscricao.cpfEnvio | mxFiltroFormatarCPFCNPJ}}
                            </span>
							<br/>
							Data:
							<span class="subheading font-weight-black primary--text">
				                {{ inscricao.dtEnvio }} às {{ inscricao.hrEnvio }}
							</span>
						</div>
					</v-card-text>
				</v-card>
			</v-col>
		</v-row>
	</v-container>
</template>

<script>
  import GrupoPerguntas from "./GrupoPerguntas";
  import MxFilters from '@/modules/shared/mixins/filters';
  import File from '@/modules/shared/components/File';
  import {mapActions} from 'vuex';

  export default {
    name: 'Grupo',
    components: {GrupoPerguntas, File},
    mixins: [MxFilters],
    props: {
      downloadResumo: {
        type: Function,
        required: true
      },
      enviarPreRequisito: {
        type: Function,
        required: true
      },
      grupos: {
        type: Array,
        required: true
      },
      isLoadingGrupo: {
        type: Boolean
      },
      edit: {
        type: Boolean
      },
      dialogStatus: {
        type: Boolean
      },
      handleGrupo: {
        type: Function
      },
      enviarInscricao: {
        type: Function
      },
      inscricao: {
        type: Object
      }
    },
    data() {
      return {
        overlay: false,
        anexo: {},
        readonlyFile: false,
        preRequisitoHabilitado: false,
        preRequisitos: [],
        proximo: false,
        isChecked: false,
        isCalculated: false,
        aba: '0',
        pontuacaoTotal: 0,
        calculado: false
      }
    },
    computed: {
      editar() {
        if (this.edit) {
          return this.calcularPontuacaoTotal();
        }
        return 0;
      }
    },
    watch: {
      dialogStatus(val) {
        if (!val) {
          this.pontuacaoTotal = 0;
          this.aba = '0';
          this.anexo = {};
        }
      },
      anexo() {
        if (this.edit) {
          this.marcarOpcoesGrupo0();
        }

        this.liberarBotoes();
        this.liberarInscricao();
      },
      edit(val) {
        if (val) {
          this.calcularPontuacaoTotal();
        }
      }
    },
    mounted() {
      this.liberarBotoes();
    },
    methods: {
      mostrarResumo() {
          this.overlay = true;
          this.handleGrupo(9).finally(() => {
              this.downloadResumo().finally(() => this.overlay = false);
          });
      },
      liberarBotoes() {
        let hasAnexo = !!Object.keys(this.anexo).length;

        this.preRequisitoHabilitado = (this.inscricao.hasPreRequisito && hasAnexo && this.edit);
        this.proximo = ((this.inscricao.hasPreRequisito && this.edit) && (this.inscricao.hasPreRequisito && !hasAnexo));
      },
      ...mapActions({
        downloadArquivo: 'shared/downloadArquivo',
      }),
      marcarOpcoesGrupo0() {
        this.grupos[0].perguntas.forEach(grupo0 => {
          if (grupo0.tp_item === 'R' && grupo0.st_resposta) {
            if (this.preRequisitos.length <= 3) {
              this.preRequisitos.push(grupo0);
            }
          }
        });
      },
      alterarArquivo(inscricao) {
        // this.preRequisitoHabilitado = false;
        this.proximo = false;
        inscricao.arquivo = false;
      },
      iniciarInscricao() {
        let preRequisitos = this.preRequisitos;
        preRequisitos.ds_arquivo = this.anexo.file;
        this.enviarPreRequisito(preRequisitos).then(() => {
          this.preRequisitoHabilitado = true;
          this.aba = '1';
          this.proximo = true;
        });
      },
      nextTab() {
        this.aba = (parseInt(this.aba, 10) + 1).toString();
        this.switchTab(this.aba);
      },
      prevTab() {
        let aba = (parseInt(this.aba, 10) - 1).toString();
        this.aba = aba;
        if (aba !== '0') {
          this.switchTab(this.aba);
        } else {
          this.preRequisitoHabilitado = false;
        }
      },
      switchTab(tabId) {
        this.proximo = this.inscricao.hasPreRequisito && this.edit && tabId !== '9' || tabId !== '0' && !this.edit && tabId !== '9';

        if (this.dialogStatus) {
          this.handleGrupo(tabId, false);
        }
      },
      liberarInscricao() {
        // this.preRequisitoHabilitado = !!((preRequisitos.length === 4 || this.edit) && (Object.keys(this.anexo).length > 0 && !this.$refs.arquivo[0].fileHasError()));
        this.preRequisitoHabilitado = !!((this.preRequisitos.length === 4 && Object.keys(this.anexo).length > 0 || Object.keys(this.anexo).length === 0 && this.edit) && (Object.keys(this.anexo).length > 0 && !this.$refs.arquivo[0].fileHasError()));
      },
      calculaPontuacao(pontuacao, operacao, grupo, idGrupo, grupoInteiro = []) {
        if (idGrupo === 0) {
          if (operacao) {
            this.preRequisitos.push(grupo);
          } else {
            this.preRequisitos = this.preRequisitos.filter(grupo0 => {
              return grupo.co_formulario_item_inscricao !== grupo0.co_formulario_item_inscricao
            });
          }

          this.liberarInscricao();
          return true;
        }

        if (idGrupo === 5) {
          this.grupos[5].perguntas.forEach(grupo5 => {
            if (grupo.co_formulario_item_inscricao !== grupo5.co_formulario_item_inscricao) {
              grupo5.st_resposta = false;
            }
          });

          if (operacao && !this.isCalculated) {
            this.pontuacaoTotal += pontuacao;
          }

          if (!operacao && this.isCalculated) {
            this.pontuacaoTotal -= pontuacao;
            this.isCalculated = false;
          }

          if (operacao) {
            this.isCalculated = true;
          }
          return true;
        }

        if (idGrupo === 1) {
          if (grupo.label === 'a) EXTRA 2: O município realizou os Jogos nas seis modalidades propostas (um ponto);') {
            let idItemAnterior = grupo.co_formulario_item_inscricao - 1;
            this.grupos[1].perguntas.forEach(grupo1 => {
              if (grupo1.co_formulario_item_inscricao === idItemAnterior) {
                if(grupo1.st_resposta && operacao) {
                  // grupo1.st_resposta = operacao;
                  grupo1.disabled = operacao;
                }

                if(!operacao) {
                  grupo1.disabled = false;
                }

                if(!grupo1.st_resposta && operacao) {
                  grupo1.st_resposta = operacao;
                  grupo1.disabled = operacao;
                  pontuacao++;
                }

              }
            });
          }
        }

        operacao ? this.pontuacaoTotal += pontuacao : this.pontuacaoTotal -= pontuacao;
      },
      calcularPontuacaoTotal() {
        let pontuacao = 0;
        this.grupos.forEach(grupos => {
          grupos.perguntas.forEach(pergunta => {
            if (pergunta.value && pergunta.st_resposta === true) {
              pontuacao += pergunta.nu_pontuacao;
            }
          });
        });
        return pontuacao;
      },
    },
  }
</script>
