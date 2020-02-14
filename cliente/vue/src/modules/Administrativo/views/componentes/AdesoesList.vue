<template>
  <v-container
    fluid
  >
    <v-row>
      <v-col>
        <download-arquivos
          :action-export="downloadAdesao"
          :filtro="filtroAdesoesMunicipioGetter || {}"
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
              item-key="co_adesao"
            >
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
  import {mapActions, mapGetters} from "vuex";
  import DownloadArquivos from "../../../shared/components/DownloadArquivos";

  export default {
    name: "AdesoesList",
    components: {DownloadArquivos},
    data() {
      return {
        overlay: false,
        loading: false,
        stopWatch: false,
        noDataText: 'Não foi localizado município!',
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
        ],
        itens: []
      }
    },
    mounted() {
      this.limparFiltro();
    },
    computed: {
      ...mapGetters({
        adesoesGetter: 'Administrativo/adesoesMunicipio',
        filtroAdesoesMunicipioGetter: 'Administrativo/filtroAdesoesMunicipio'
      }),
    },
    watch: {
      adesoesGetter(data) {
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
          let options = {
            page: value.page,
            per_page: value.itemsPerPage,
            order_by: value.sortBy[0],
            sort_desc: value.sortDesc[0],
          };

          const filtro = this.filtroAdesoesMunicipioGetter;
          const params = {...filtro , ...options};

          if (this.stopWatch) {
             this.stopWatch = false;
             return value;
          }

          this.loading = true;
          this.listarAdesoes(params)
            .finally(() =>  this.loading = false);
        },
        deep: true,
      }
    },
    methods: {
      ...mapActions({
        listarAdesoes: 'Administrativo/listarAdesoes',
        downloadAdesao: 'Administrativo/downloadAdesao',
        limparFiltro: 'Administrativo/limparFiltro',
      })
    }
  }
</script>

<style scoped>

</style>
