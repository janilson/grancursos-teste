<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-card-text>
      <v-row justify="center">
        <v-img
          :src="require('@/assets/logomarca_municipio_mais_cidadao.png')"
          max-width="280"
        >
        </v-img>
      </v-row>
      <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        @submit.prevent="login"
      >
        <v-text-field
          v-mask="['###.###.###-##']"
          append-icon="person"
          name="login"
          label="CPF"
          validate-on-blur
          type="text"
          :rules="[rules.required, rules.validarCPF]"
          autocomplete="no_cpf"
          @input="model.nu_cpf = mxRemoveMask($event)"
        />
        <v-text-field
          id="password"
          v-model="model.ds_senha"
          :append-icon="mostrarSenha ? 'visibility' : 'visibility_off'"
          :type="mostrarSenha ? 'text' : 'password'"
          label="Senha"
          :rules="[rules.required]"
          name="password"
          autocomplete="current-password"
          @click:append="mostrarSenha = !mostrarSenha"
        />
        <v-row no-gutters>
          <v-col align="end" class="pb-4">
            <router-link to="/login/recuperar-senha">
              Esqueceu a senha?
            </router-link>
          </v-col>
        </v-row>
        <div class="login-btn">
          <v-btn
            type="submit"
            color="primary"
            class="mb-2"
            block
            :disabled="!valid"
            :loading="loading"
          >
            Entrar
          </v-btn>
          <v-spacer/>
        </div>
      </v-form>
    </v-card-text>
  </v-card>
</template>

<script>
  import {mapActions} from 'vuex';

  import Validate from '@/modules/shared/util/validate';
  import MxMask from '@/modules/shared/mixins/mask';

  export default {
    name: 'Login',
    mixins: [MxMask],
    data: () => ({
      appTitle: "Município +Cidadão",
      loading: false,
      mostrarSenha: false,
      valid: true,
      model: {
        nu_cpf: '',
        ds_senha: '',
      },
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        validarCPF: value => Validate.isCpfValido(value) || 'CPF inválido',
      }
    }),
    methods: {
      ...mapActions({
        autenticarUsuario: 'Autenticacao/autenticarUsuario',
      }),
      login() {
        if (!this.$refs.form.validate()) {
          return;
        }

        this.loading = true;

        this.autenticarUsuario(this.model)
          .then(() => {
             this.$router.push({name : 'Dashboard'})
          })
          .finally(() => this.loading = false);
      }
    }
  };
</script>
