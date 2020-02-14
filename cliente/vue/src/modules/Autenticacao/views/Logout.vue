<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <card-carregando
        v-if="loading"
        text="Aguarde, encerrando a sessão"
      />
      <div
        v-else
        class="text-center"
      >
        <div style="padding: 20px">
          <h3 class="display-1 font-weight-light">
            Sessão finalizada com sucesso!
          </h3>
          <v-btn
            class="mt-6"
            outlined
            block
            color="primary"
            to="/login"
          >
            Fazer login novamente
          </v-btn>
        </div>
      </div>
    </v-card-text>
  </v-card>
</template>

<script>
import { mapActions } from 'vuex';
import CardCarregando from '@/core/components/card/CardCarregando';

export default {
  components: { CardCarregando },
  data: () => ({
    appTitle: process.env.VUE_APP_TITLE,
    loading: true,
  }),
  created() {
    this.acionarLogout();
  },
  methods: {
    ...mapActions({
      logout: 'Autenticacao/logout',
    }),
    acionarLogout() {
      this.loading = true;
      setTimeout(() => {
        this.loading = false;
        this.logout();
      }, 2000);
    },
  },
};
</script>
