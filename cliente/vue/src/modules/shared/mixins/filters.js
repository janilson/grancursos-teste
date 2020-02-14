export default {
  filters: {
    mxFiltroLabelStatus(status) {
      return status ? 'Sim' : 'Não';
    },
    mxFiltroFormatarCPFCNPJ(value) {
      let data = '';
      if (value) {
        data = value.trim();
      }
      const currentValue = data;

      if (currentValue.length > 11) {
        return currentValue.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
      }

      return currentValue.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
    },
    mxFiltroFormatarTelefone(value) {
      let data = '';
      if (value) {
        data = value.trim();
      }
      const currentValue = data;

      if (currentValue.length > 10) {
        return currentValue.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
      }

      return currentValue.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
    },
    mxFiltroFormatarData(date) {
      if (!date) return null;
      const [year, month, day] = date.split('-');
      return `${day}/${month}/${year}`;
    },
  },
};
