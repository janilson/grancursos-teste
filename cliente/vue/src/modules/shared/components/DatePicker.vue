<template>
  <v-menu
      ref="menu"
      v-model="menu"
      transition="scale-transition"
      :close-on-content-click="false"
      offset-y
      min-width="290px"
  >
    <template v-slot:activator="{ on }">
      <v-text-field
          v-model="dateFormatted"
          v-mask="['##/##/####']"
          v-bind="$attrs"
          :label="label"
          :rules="[validarData(dateFormatted)]"
          return-masked-value
          v-on="on"
      />
    </template>
    <v-date-picker
        v-model="date"
        no-title
        scrollable
        locale="pt-BR"
        @input="menu = false"
    >
      <v-btn text color="primary" @click="reset">Limpar</v-btn>
    </v-date-picker>
  </v-menu>
</template>


<script>
  import MxMask from '@/modules/shared/mixins/mask';

  export default {
    name: 'DatePicker',
    mixins: [MxMask],
    props: {
      value: {
        type: String,
        default: '',
      },
      label: {
        type: String,
        default: 'Data',
      },
    },
    data: () => ({
      menu: false,
      date: '',
      dateFormatted: '',
      regexDate: /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/
    }),
    watch: {
      value(val) {
        if(!val) return null;
        this.date = val.substr(0, 10);
      },
      date(val) {
        this.dateFormatted = this.formatDate(val);
        this.$emit('input', val);
      },
      dateFormatted(val) {
        if (val.match(this.regexDate)) {
          this.$emit('input', this.formatDateUsa(val));
        }

        if (!val) {
          this.$emit('input', '');
        }
      }
    },
    mounted() {
      this.date = this.value;
    },
    methods: {
      formatDate(date) {
        if (!date) return null;
        const [year, month, day] = date.substr(0, 10).split('-');
        return `${day}/${month}/${year}`;
      },
      formatDateUsa(date) {
        if (!date) return null;
        const [day, month, year] = date.substr(0, 10).split('/');
        return `${year}-${month}-${day}`;
      },
      reset() {
        this.menu = false;
        this.dateFormatted = '';
        this.$emit('input', '');
      },
      validarData(data) {
        return (!data || !!data.match(this.regexDate)) || 'Data inválida, favor corrigir a data';
      }
    },
  };
</script>