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
					@click="closeModal"
					dark
					icon
				>
					<v-icon>close</v-icon>
				</v-btn>
				<v-toolbar-title>
					<v-row>
						<v-col class="text-md-center display-1 font-weight-bold">
							Formulário de Inscrição do Município {{dadosEnvio.noMunicipio}} - {{dadosEnvio.sgUf}}
						</v-col>
					</v-row>
				</v-toolbar-title>
				<v-spacer/>
			</v-toolbar>

			<v-card-text>
				<accordion-grupos :grupos="grupos" :dadosEnvio="dadosEnvio" :pontuacaoTotal="nuPontuacaoTotal" />
			</v-card-text>
		</v-card>
	</v-dialog>

</template>

<script>
	import AccordionGrupos from "./AccordionGrupos";

  export default {
    name: 'ModalVisualizarGrupos',
    components: { AccordionGrupos },
    props: {
      value: {
        type: Boolean
      },
      dadosEnvio: {
        type: Object,
        required: true
      },
      nuPontuacaoTotal: {
        type: Number,
        required: true
      },
      grupos: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        dialog: false,
      }
    },
    watch: {
      value(valor) {
        this.dialog = valor;
      },
      dialog(valor) {
        if (!valor) {
          this.$emit('input', valor);
        }
      }
    },
    methods: {
      closeModal() {
        this.$emit('input', false);
      },
    }
  }
</script>
