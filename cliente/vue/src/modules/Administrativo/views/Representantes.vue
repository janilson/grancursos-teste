<template>
  <v-container>
    <representantes-filtro></representantes-filtro>
    <representantes-list></representantes-list>
  </v-container>
</template>

<script>
  import RepresentantesFiltro from "./componentes/RepresentantesFiltro";
  import RepresentantesList from "./componentes/RepresentantesList";


  export default {
    name: "Representantes",
    components: {RepresentantesList, RepresentantesFiltro}
  }
</script>

<style scoped>

</style>
