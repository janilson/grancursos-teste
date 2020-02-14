<template>
  <v-container
    id="messaging"
    class="fill-height pa-0 ma-0 messaging fluid"
  >
    <template v-if="!$vuetify.breakpoint.smAndDown">
      <v-row row>
        <v-col
          lg="3"
          class="white"
        >
          <chat-history />
        </v-col>
        <v-col lg="9">
          <chat-window />
        </v-col>
      </v-row>
    </template>
    <template v-else>
      <v-row column>
        <v-col
          v-if="showSidebar"
          sm="12"
          class="white"
        >
          <chat-history />
        </v-col>
        <v-col
          v-if="showWindow"
          sm="12"
        >
          <chat-window />
        </v-col>
      </v-row>
    </template>
  </v-container>
</template>
<script>
import ChatHistory from './ChatHistory';
import ChatWindow from './ChatWindow';

export default {
  components: {
    ChatHistory,
    ChatWindow,
  },
  data() {
    return {};
  },
  computed: {
    showSidebar() {
      return this.$route.params.uuid === undefined;
    },
    showWindow() {
      return this.$route.params.uuid !== undefined;
    },
  },
};
</script>
