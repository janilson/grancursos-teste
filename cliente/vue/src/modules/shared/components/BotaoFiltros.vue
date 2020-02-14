<template>
  <v-tooltip
    top
  >
    <template v-slot:activator="{ on }">
      <v-btn
        outlined
        color="primary"
        small
        v-on="on"
        @click="$emit('input', !value)"
      >
        Filtros
        <v-icon
          v-if="value"
          class="ml-2"
          small
        >
          close
        </v-icon>
        <v-icon
          v-else
          class="ml-2"
          small
        >
          filter_list
        </v-icon>
      </v-btn>
    </template>
    <span v-if="value">Abrir pesquisa</span>
    <span v-else>Fechar pesquisa</span>
  </v-tooltip>
</template>

<script>
export default {
  name: 'BotaoFiltros',
  props: {
    value: {
      type: Boolean,
      default: false,
    },
  },
};
</script>
