<template>
  <v-form
    ref="form"
  >
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="4"
        >
          <v-select
            :items="lista_regiao"
            item-text="no_regiao"
            item-value="no_regiao"
            label="Região"
            v-model="formulario.no_regiao"
          />
        </v-col>

        <v-col
          cols="12"
          md="4"
        >
          <v-select
            :items="lista_grupo_municipio"
            item-text="no_grupo_municipio"
            item-value="co_grupo_municipio"
            label="Grupo Municipal"
            v-model="formulario.tp_grupo_municipio"
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
            @click="filtrarAdesoes"
            color="primary"
            class="mr-4 float-right"
          >Aplicar Filtro
          </v-btn>
        </v-col>
      </v-row>
    </v-container>
  </v-form>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";

  export default {
    name: "AdesoesFiltro",
    data() {
      return {
        lista_regiao: [
          {
            no_regiao: 'Norte',
          },
          {
            no_regiao: 'Nordeste',
          },
          {
            no_regiao: 'Centro-Oeste',
          },
          {
            no_regiao: 'Sudeste',
          },
          {
            no_regiao: 'Sul',
          }
        ],
        lista_grupo_municipio: [
          {
            co_grupo_municipio: 1,
            no_grupo_municipio: 'Grupo I - Com até 20.000 habitantes'
          },
          {
            co_grupo_municipio: 2,
            no_grupo_municipio: 'Grupo II - De 20.001 até 50.000 habitantes'
          },
          {
            co_grupo_municipio: 3,
            no_grupo_municipio: 'Grupo III - De 50.001 até 100.000 habitantes'
          },
          {
            co_grupo_municipio: 4,
            no_grupo_municipio: 'Grupo IV - De 100.001 até 500.000 habitantes'
          },
          {
            co_grupo_municipio: 5,
            no_grupo_municipio: 'Grupo V - Com mais de 500.000 habitantes'
          }
        ],
        formulario: {
          no_regiao: '',
          tp_grupo_municipio: ''
        }
      }
    },
    computed: {
      ...mapGetters({
        filtroAdesoesMunicipioGetter: 'Administrativo/filtroAdesoesMunicipio'
      }),
    },
    methods: {
      filtrarAdesoes() {
        if (!this.$refs.form.validate()) {
          return false;
        }
        let formulario = {...this.formulario};
        Object.keys(formulario).forEach((key) => formulario[key] !== '' || delete formulario[key]);
        const filtro = this.filtroAdesoesMunicipioGetter;

        const params = {...filtro,...formulario};
        delete params.filtro;

        params.page = 1;

        this.listarAdesoes(params);
      },
      reset() {
        this.$refs.form.reset();
        this.limparAdesoes();
        this.limparFiltro();
      },
      ...mapActions({
        listarAdesoes: 'Administrativo/listarAdesoes',
        limparAdesoes: 'Administrativo/limparAdesoes',
        limparFiltro: 'Administrativo/limparFiltro'
      }),
    }
  }
</script>

<style scoped>

</style>
