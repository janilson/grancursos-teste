<template>
	<v-dialog
		fullscreen
		hide-overlay
		transition="dialog-bottom-transition"
		v-model="dialog"
	>
		<v-card>
			<v-toolbar
				color="primary"
				dark
			>
				<v-btn
					@click="closeDialog()"
					dark
					icon
				>
					<v-icon>close</v-icon>
				</v-btn>
				<v-toolbar-title>
					<v-row>
						<v-col class="text-md-center display-1 font-weight-bold">
							Inscrição do Município {{ inscricao.label }}
						</v-col>
						<v-col class="caption font-weight-bold" style="margin-left: 40px;">
							CPF : <span
							class="font-weight-regular">{{ inscricao.cpf | mxFiltroFormatarCPFCNPJ }}</span><br/>
							E-mail : <span class="font-weight-regular">{{ inscricao.email }}</span>
						</v-col>
					</v-row>
				</v-toolbar-title>
				<v-spacer/>
			</v-toolbar>

			<v-card-text>
				<grupo
					:download-resumo="downloadResumo"
                    :enviar-pre-requisito="enviarPreRequisito"
					:dialogStatus="dialog"
					:edit="edit"
					:enviarInscricao="abrirDialogoEnviar"
					:grupos="grupos || []"
					:handleGrupo="handleGrupo"
					:inscricao="inscricao"
					:isLoadingGrupo="isLoadingGrupo"
				/>
			</v-card-text>
		</v-card>

		<v-dialog
			max-width="360"
			v-model="modalConfirmacaoEnviar"
		>
			<v-card>
				<v-card-title class="headline">
					Enviar Inscrição
				</v-card-title>

				<v-card-text>
					Confirma o envio da inscrição ao Ministério?
				</v-card-text>

				<v-card-actions>
					<v-spacer/>

					<v-btn
						@click="modalConfirmacaoEnviar = false"
						color="red darken-1"
						text
					>
						Não
					</v-btn>

					<v-btn
						@click="confirmarEnvio()"
						color="green darken-1"
						text
					>
						Sim
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>

		<v-dialog fullscreen v-model="loadingInscricao">
			<v-container fill-height fluid style="background-color: rgba(255, 255, 255, 0.5);">
				<v-layout align-center justify-center>
					<v-progress-circular
						color="primary"
						indeterminate>
					</v-progress-circular>
				</v-layout>
			</v-container>
		</v-dialog>
	</v-dialog>
</template>

<script>
  import Grupo from './Grupo';
  import DialogConfirmacao from "../../../../core/components/dialog/DialogConfirmacao";
  import MxFiltros from '@/modules/shared/mixins/filters';

  export default {
    name: 'ModalNovaInscricao',
    components: {Grupo, DialogConfirmacao},
    mixins: [
      MxFiltros,
    ],
    props: {
      enviarPreRequisito: {
        type: Function,
        required: true
      },
      downloadResumo: {
        type: Function,
        required: true
      },
      isLoadingGrupo: {
        type: Boolean
      },
      edit: {
        type: Boolean
      },
      inscricao: Object,
      grupos: {
        type: Array,
        required: true
      },
      value: {
        type: Boolean,
        default: false,
      },
      handleGrupo: {
        type: Function
      },
      enviarInscricao: {
        type: Function
      },
      listar: {
        type: Function
      }
    },
    data: () => ({
      dialog: false,
      modalConfirmacaoEnviar: false,
      statusOriginal: false,
      loadingInscricao: false
    }),
    watch: {
      value(valor) {
        this.dialog = valor;
        this.statusOriginal = this.inscricao.status;
      },
      dialog(valor) {
        if (!valor) {
          this.$emit('input', valor);
        }
      }
    },
    methods: {
      abrirDialogoEnviar() {
        this.modalConfirmacaoEnviar = true;
      },
      closeDialog() {
        this.dialog = false;
        this.modalConfirmacaoEnviar = false;

        if (this.statusOriginal !== this.inscricao.status) {
          this.$props.listar();
          this.statusOriginal = this.inscricao.status;
        }
      },
      confirmarEnvio() {
        this.loadingInscricao = true;
        this.modalConfirmacaoEnviar = false;
        this.enviarInscricao();
      }
    },
  }
</script>
