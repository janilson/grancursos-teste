<template>
  <v-card>
    <v-toolbar
      flat
      dense
      color="transparent"
    >
      <v-toolbar-title class="font-weight-light">
        {{ titulo }}
      </v-toolbar-title>
    </v-toolbar>
    <v-divider />
    <v-card-text class="pa-0">
      <v-container
        fluid
        grid-list-lg
        text-center
      >
        <slot />
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'SCardConteudo',
  props: {
    titulo: {
      type: String,
      default: '',
    },
  },
};
</script>
