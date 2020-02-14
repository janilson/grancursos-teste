<template>
  <v-card class="elevation-1 pa-3 login-card">
    <v-window v-model="step">
      <v-window-item :value="1">
        <v-card-title>
          <v-row justify="center">
            <h3 class="display-1 font-weight-light text--primary">
              {{ $route.meta.title }}
            </h3>
          </v-row>
        </v-card-title>
        <v-card-text>
          <v-row >
            <span style="font-size: 16px">
              Informe os dados abaixo para que o sistema crie nova senha de acesso ao Município +Cidadão e encaminhe ao e-mail informado abaixo.
            </span>
          </v-row>
          <v-form
            ref="form"
            v-model="valid"
            lazy-validation
          >
            <v-text-field
              v-mask="['###.###.###-##']"
              prepend-icon="account_circle"
              name="login"
              label="CPF"
              validate-on-blur
              placeholder="Informe o CPF conforme adesão."
              type="text"
              :rules="[rules.required, rules.validarCPF]"
              @input="usuario.nu_cpf = mxRemoveMask($event)"
            />
            <v-text-field
              v-model="usuario.ds_email"
              prepend-icon="mail_outline"
              name="ds_email"
              label="E-mail"
              validate-on-blur
              placeholder="Informe o e-mail correspondente ao CPF informado."
              type="text"
              :rules="[rules.required, rules.emailValido]"
            />
          </v-form>
        </v-card-text>
        <v-container fluid>
          <v-btn
            :disabled="!valid"
            :loading="loading"
            type="submit"
            block
            color="primary"
            @click="recuperar"
          >
            Confirmar criação de nova senha
          </v-btn>
          <v-spacer/>
          <v-row class="px-4">
            <v-col
              lg="6"
              sm="6"
            >
              <v-row justify="start">
                <router-link to="/login">
                  Voltar
                </router-link>
              </v-row>
            </v-col>
          </v-row>
        </v-container>
      </v-window-item>
      <v-window-item :value="2">
        <v-card-text>
          <div class="text-center">
            <v-icon
              size="80px"
              color="primary"
            >
              check_circle
            </v-icon>
            <h3
              class="title font-weight-light mb-2"
            >
              Nova senha foi gerada com sucesso e encaminhada ao email informado
            </h3>
          </div>
        </v-card-text>
        <!-- <v-card-actions> -->
        <v-btn
          block
          color="primary"
          :to="{ name: 'login' }"
        >
          Login
        </v-btn>
        <!-- </v-card-actions> -->
      </v-window-item>
    </v-window>
  </v-card>
</template>

<script>
  import {mapActions} from 'vuex';
  import Validate from '@/modules/shared/util/validate';
  import MxMask from '@/modules/shared/mixins/mask';

  export default {
    mixins: [MxMask],
    data: () => ({
      loading: false,
      mostrarSenha: false,
      valid: true,
      menu: false,
      step: 1,
      usuario: {
        nu_cpf: '',
        ds_email: '',
      },
      rules: {
        required: value => !!value || 'Este campo é obrigatório',
        validarCPF: value => Validate.isCpfValido(value) || 'CPF inválido',
        emailValido: value => Validate.isEmailValido(value) || 'E-mail inválido',
      },
    }),
    methods: {
      ...mapActions({
        recuperarSenha: 'Autenticacao/recuperarSenha',
        mensagemErro: 'app/setMensagemErro',
      }),
      recuperar() {
        if (!this.$refs.form.validate()) {
          return;
        }
        this.loading = true;

        this.recuperarSenha(this.usuario)
          .then(() => {
            this.step = 2;
          })
          .catch((error) => {
            this.loading = false;
            this.mensagemErro(error.response.data.message);
          });
      },
    },
  };
</script>
