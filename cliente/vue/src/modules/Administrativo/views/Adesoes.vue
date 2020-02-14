<template>
  <v-container>
    <adesoes-filtro></adesoes-filtro>
    <adesoes-list></adesoes-list>
  </v-container>
</template>

<script>
  import AdesoesFiltro from "./componentes/AdesoesFiltro";
  import AdesoesList from "./componentes/AdesoesList";

  export default {
    name: "Adesoes",
    components: {AdesoesList, AdesoesFiltro}
  }
</script>

<style scoped>

</style>
