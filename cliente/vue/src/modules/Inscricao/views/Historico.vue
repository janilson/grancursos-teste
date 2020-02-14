<template>
  <v-container>
    <historico-filtro/>
    <historico-list/>
  </v-container>
</template>
<script>
    import {mapActions} from 'vuex';
    import HistoricoFiltro from "./components/HistoricoFiltro";
    import HistoricoList from "./components/HistoricoList";

    export default {
        name: 'Histórico',
        components: {
            HistoricoFiltro, HistoricoList
        },
        data() {
            return {}
        },
        mounted() {
            this.limparListagem();
        },
        methods: {
            ...mapActions({
                limparHistorico: 'Inscricao/limparHistorico',
                limparFiltroHistorico: 'Inscricao/limparFiltroHistorico'
            }),
            limparListagem() {
                this.limparHistorico();
                this.limparFiltroHistorico();
            },
        }
    }
</script>
