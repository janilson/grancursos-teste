<template>
  <v-container class="fill-height pa-0 ma-0 chat-drawer-container fluid">
    <template v-if="!$vuetify.breakpoint.smAndDown">
      <v-row row>
        <v-col
          lg="3"
          class="chat-contact--sidebar white"
        >
          <chat-contact-list />
        </v-col>
        <v-col lg="9">
          <chat-contact-profile />
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
          <chat-contact-list />
        </v-col>
        <v-col
          v-if="showWindow"
          sm="12"
        >
          <chat-contact-profile />
        </v-col>
      </v-row>
    </template>
  </v-container>
</template>
<script>
import ChatContactList from './ChatContactList';
import ChatContactProfile from './ChatContactProfile';

export default {
  components: {
    ChatContactList,
    ChatContactProfile,
  },
  data() {
    return {
      chat: null,
      selectedTab: null,
    };
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
