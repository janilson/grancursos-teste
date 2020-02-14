import { mask } from 'vue-the-mask';

export default {
  directives: { mask },
  methods: {
    mxRemoveMask(texto) {
      if (!texto) return '';

      return texto.replace(/\D+/g, '');
    },
  },
};
