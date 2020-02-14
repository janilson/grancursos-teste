<template>
	<v-card>
		<v-card-text>
			<div class="subheading font-weight-bold" id="g1-title">
				<span v-if="idGrupo !== 0">
          <span v-if="idGrupo !== 9">Grupo {{ idGrupo }} - </span>
          {{ dsGrupo }}
          (pontuação máxima: <span class="red--text font-weight-bold">{{ pontuacaoTotal }}</span>)
				</span>
			</div>
			<template v-for="grupo in perguntas">
				<div
					class="v-input ml-4 theme--light v-input--selection-controls v-input--checkbox font-weight-bold"
					v-if="(grupo.tp_item === 'P')">
					<div class="vfilep-input__control">
						<div class="v-messages theme--light" v-if="(grupo.cod > 0)"></div>
						<div class="v-messages theme--light" v-if="(grupo.cod > 0)"></div>
						<div class="v-input__slot">
							{{ grupo.label }}
						</div>
					</div>
				</div>
				<v-checkbox
					:disabled="grupo.disabled || (preRequisito && idGrupo === 0 && grupo.st_resposta)"
					:key="grupo.co_formulario_item_inscricao"
					:label="grupo.label"
					:value="grupo.st_resposta"
					@change="calcularPontuacao(grupo.nu_pontuacao, grupo.st_resposta, grupo, idGrupo)"
					class="ml-4 font-weight-regular"
					v-else
					v-model="grupo.st_resposta"
				/>
			</template>

			<slot name="iniciar-inscricao"></slot>
			<slot name="btn-enviar"></slot>

		</v-card-text>
	</v-card>
</template>

<script>



  export default {
    name: 'GrupoPerguntas',
    props: {
      perguntas: {
        type: Array,
        required: true
      },
      edit: {
        type: Boolean
      },
      preRequisito: {
        type: Boolean
      },
      idGrupo: {
        type: Number,
        required: true
      },
      dsGrupo: {
        type: String,
        required: true
      },
      pontuacaoTotal: {
        type: Number,
        required: true
      },
      calculaPontuacao: {
        type: Function
      }
    },
    data() {
      return {
        modelGrupo: [],
      }
    },
    methods: {

      calcularPontuacao(nuPontuacao, stResposta, grupo, coGrupo) {
        this.calculaPontuacao(nuPontuacao, stResposta, grupo, coGrupo);
      }
    }
  }
</script>
<style>
  .v-input label {
    font-size: 15px;
  }
</style>
