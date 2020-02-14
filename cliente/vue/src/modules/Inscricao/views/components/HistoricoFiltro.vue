<template>
  <v-form
    lazy-validation
    ref="form"
    v-model="isFormValid"
  >
    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="3"
        >
          <v-select
            :items="listaMinhasAdesoes"
            :rules="[rules.required]"
            @change="selecionarInscricao"
            item-text="label"
            item-value="value"
            label="Selecione o Município"
            required
            v-model="formulario.co_adesao"
          />
        </v-col>
        <v-col
          cols="12"
          md="3"
        >
          <date-picker label="Data" v-model="formulario.dt_resposta"></date-picker>
        </v-col>
        <v-col
          cols="12"
          md="3"
        >
          <v-text-field label="Nome" v-model="formulario.no_servidor"></v-text-field>
        </v-col>
        <v-col
          cols="12"
          md="3"
        >
          <v-select
            :items="grupos"
            item-text="ds_grupo"
            item-value="co_grupo"
            label="Grupo"
            required
            v-model="formulario.co_grupo"
          />
        </v-col>
      </v-row>
      <v-row>
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
            @click="filtrarInscricao"
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
  import {mapActions, mapGetters} from 'vuex';
  import CardCarregando from '@/core/components/card/CardCarregando';
  import DatePicker from "@/modules/shared/components/DatePicker";

  export default {
    name: 'HistoricoFiltro',
    components: {
      CardCarregando, DatePicker
    },
    watch: {
      'formulario.dt_resposta': function (val) {
        if (!val) {
          this.limparDataPesquisaHistorico();
          this.formulario.dt_resposta = '';
          return;
        }
      },
    },
    data: () => ({
      isFormValid: false,
      appTitle: process.env.VUE_APP_TITLE,
      loading: true,
      formulario: {
        co_adesao: null,
        dt_resposta: '',
        no_servidor: null,
        co_grupo: null
      },
      inscricaoSelecionada: {},
      dialog: false,
      listaMinhasAdesoes: [],
      grupos: [],
      rules: {
        required: v => !!v || "Campo não preenchido",
      }
    }),
    methods: {
      filtrarInscricao() {
          if (!this.$refs.form.validate()) {
              return false;
          }
          let formulario = {...this.formulario};
          Object.keys(formulario).forEach((key) => formulario[key] !== '' || delete formulario[key]);
          const filtro = this.filtroHistoricosGetter;

          const params = {...filtro,...formulario};
          delete params.filtro;

          params.page = 1;

          this.listarHistorico(params);
      },

      selecionarInscricao(inscricao) {
        this.inscricaoSelecionada = inscricao;
        this.coAdesao = inscricao.value;
      },
      ...mapActions({
        listarMinhasAdesoes: 'Inscricao/listarMinhasAdesoes',
        listarHistorico: 'Inscricao/listarHistorico',
        listarGrupos: 'Inscricao/listarGrupos',
        limparHistorico: 'Inscricao/limparHistorico',
        listarTodasAdesoes: 'Inscricao/listarTodasAdesoes',
        limparDataPesquisaHistorico: 'Inscricao/limparDataPesquisaHistorico'
      }),
      obterMinhasAdesoes() {
        this.listarMinhasAdesoes().then(() => {
          this.listaMinhasAdesoes = this.minhasAdesoesGetter;
        });
      },
      obterTodasAdesoes() {
        this.listarTodasAdesoes().then(() => {
          this.listaMinhasAdesoes = this.adesoesGetter;
        });
      },
      reset() {
        this.$refs.form.reset();
        this.limparHistorico();
      }
    },
    computed: {
      ...mapGetters({
        adesoesGetter: 'Inscricao/todasAdesoes',
        minhasAdesoesGetter: 'Inscricao/adesoes',
        usuarioLogadoGetter: 'app/usuarioLogado',
        filtroHistoricosGetter: 'Inscricao/filtroHistoricos'
      }),
    },
    created() {
      this.listarGrupos().then(data => this.grupos = data);
    },
    mounted() {
      this.usuarioLogadoGetter.tp_perfil === 'E' ? this.obterMinhasAdesoes() : this.obterTodasAdesoes();
    }
  };
</script>
