import Validate from '@/modules/shared/util/validate';

export default {
  data: () => ({
    mxRegras: {
      obrigatorio: valor => !!valor || 'Este campo é obrigatório',
      emailValido: valor => Validate.isEmailValido(valor) || 'O endereço de e-mail é inválido',
      dataValida: valor => Validate.isDataValida(valor) || 'Data inválida',
      cpfValido: value => Validate.isCpfValido(value) || 'CPF inválido',
      cnpjValido: value => Validate.isCnpjValido(value) || 'CNPJ inválido',
      cepValido: value => Validate.isCepValido(value) || 'O CEP informado é inválido',
    },
  }),
};
