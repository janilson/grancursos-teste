<template>
  <div :class="className">
    <font-awesome-icon
      @click="exportarCsv"
      :class="classIcon"
      icon="file-csv"
      size="2x"
      style="cursor: pointer"
      title="CSV"/>
    <font-awesome-icon
      @click="exportarPdf"
      :class="classIcon"
      icon="print"
      size="2x"
      style="cursor: pointer"
      title="Imprimir"/>
    <font-awesome-icon
      @click="exportarExcel"
      :class="classIcon"
      icon="file-excel"
      size="2x"
      style="cursor: pointer"
      title="Excel"/>
    <v-overlay :value="isLoading">
      <v-progress-circular indeterminate size="64" class="primary--text"></v-progress-circular>
    </v-overlay>
  </div>
</template>

<script>
  export default {
    name: "DownloadArquivos",
    props: {
      actionExport: {
        type: Function,
        required: true
      },
      className: {
        type: String,
        default: 'float-right'
      },
      classNameColorIcon: {
        type: String,
        default: 'primary--text'
      },
      lista: {
        type: Array,
        required: true
      },
      filtro: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        isLoading: false,
        classIcon: `mr-4 ml-4 mt-4 ${this.classNameColorIcon}`
      }
    },
    mounted() {

    },
    methods: {
      exportarCsv() {
        if (!this.existeLista()) {
          return;
        }

        this.isLoading = true;
        this.actionExport({params: this.filtro, acceptType: 'text/csv', type: 'csv'})
            .finally(() => this.isLoading = false);
      },
      exportarPdf() {
        if (!this.existeLista()) {
          return;
        }

        this.isLoading = true;
        this.actionExport({params: this.filtro, acceptType: 'application/pdf', type: 'pdf'})
            .finally(() => this.isLoading = false);
      },
      exportarExcel() {
        if (!this.existeLista()) {
          return;
        }

        this.isLoading = true;
        this.actionExport({params: this.filtro, acceptType: 'application/xls', type: 'xls'})
            .finally(() => this.isLoading = false);
      },
      existeLista() {
        return this.lista.length;
      }
    }
  }
</script>

<style scoped>

</style>
