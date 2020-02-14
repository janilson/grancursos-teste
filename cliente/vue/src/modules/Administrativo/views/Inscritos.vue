<template>
  <v-container>
    <inscritos-filtro></inscritos-filtro>
    <inscritos-list></inscritos-list>
  </v-container>
</template>

<script>
  import InscritosFiltro from "./componentes/InscritosFiltro";
  import InscritosList from "./componentes/InscritosList";

  export default {
    name: "Inscritos",
    components: {InscritosList, InscritosFiltro}
  }
</script>

<style scoped>

</style>
