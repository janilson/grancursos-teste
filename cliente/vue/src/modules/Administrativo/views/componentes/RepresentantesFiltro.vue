<template>
  <v-form
    ref="form"
  >
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="2"
        >
          <v-text-field
            v-mask="['###.###.###-##']"
            name="nu_cpf"
            label="CPF"
            validate-on-blur
            type="text"
            autocomplete="no_cpf"
            @input="formulario.nu_cpf = mxRemoveMask($event)"
          />
        </v-col>
        <v-col
          cols="12"
          md="4"
        >
          <v-text-field
            name="no_servidor"
            label="Nome"
            validate-on-blur
            type="text"
            v-model="formulario.no_servidor"
          />
        </v-col>
        <v-col
          cols="12"
          md="1"
        >
          <v-select
            :items="lista_uf"
            item-text="sg_uf"
            item-value="co_uf"
            label="UF"
            v-model="formulario.co_uf"
            @change="selecionarMunicipio"
          />
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-select
            :items="lista_municipio"
            item-text="no_municipio"
            item-value="co_municipio"
            label="Município"
            v-model="formulario.co_municipio"
            :disabled="disabled"
          />
        </v-col>

        <v-col
          cols="12"
          md="12"
        >
          <v-btn
            color="secondary"
            class="mr-4 mb-1 float-right"
            @click="reset"
          >
            Limpar Filtro
          </v-btn>

          <v-btn
            @click="filtrarRepresentantes"
            class="mr-4 float-right"
            color="primary"
          >Aplicar Filtro
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import MxMask from '@/modules/shared/mixins/mask';

  export default {
    name: "RepresentantesFiltro",
    mixins: [MxMask],
    data() {
      return {
        disabled: true,
        lista_uf: [],
        lista_municipio: [],
        formulario: {
          nu_cpf: '',
          no_servidor: '',
          co_uf: '',
          co_municipio: ''
        }
      }
    },
   computed: {
      ...mapGetters({
          filtroRepresentantesMunicipioGetter: 'Administrativo/filtroRepresentantesMunicipio'
      }),
    },
    created() {
      this.listarUf().then(data => this.lista_uf = data);
    },
    methods: {
      filtrarRepresentantes() {
          if (!this.$refs.form.validate()) {
              return false;
          }
          let formulario = {...this.formulario};
          Object.keys(formulario).forEach((key) => formulario[key] !== '' || delete formulario[key]);
          const filtro = this.filtroRepresentantesMunicipioGetter;

          const params = {...filtro,...formulario};
          delete params.filtro;

          params.page = 1;

          this.listarRepresentantes(params);
      },
      reset() {
        this.$refs.form.reset();
        this.limparRepresentantes();
        this.limparFiltroRepresentantes();
        this.disabled = true;
      },
      ...mapActions({
        listarRepresentantes: 'Administrativo/listarRepresentantes',
        limparRepresentantes: 'Administrativo/limparRepresentantes',
        limparFiltroRepresentantes: 'Administrativo/limparFiltroRepresentantes',
        listarUf: 'Administrativo/listarUf',
        listarMunicipio: 'Administrativo/listarMunicipio'
      }),
      selecionarMunicipio() {
        this.listarMunicipio(this.formulario.co_uf)
          .then(data => {
            this.disabled = false;
            this.lista_municipio = data
          });
      }
    }
  }
</script>

<style scoped>

</style>
