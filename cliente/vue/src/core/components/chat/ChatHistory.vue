<template>
  <div class="chat-history">
    <v-toolbar
      dense
      class="chat-history-toolbar"
    >
      <v-text-field
        flat
        solo
        full-width
        clearable
        prepend-icon="search"
        label="Search"
      />
    </v-toolbar>
    <vue-perfect-scrollbar class="chat-history--scrollbar">
      <v-divider />
      <v-list
        two-line
        class="chat-history--list"
      >
        <v-subheader>History</v-subheader>
        <template v-for="(item, index) in chats">
          <v-divider :key="index" />
          <v-list-item
            :key="item.title + index"
            class="chat-list"
            avatar
            :to="chatRoute(item.uuid)"
          >
            <v-list-item-avatar :color="randomAvatarColor(item)">
              <img
                v-if="item.users.length === 1"
                :src="item.user.avatar"
              >
              <span
                v-else
                class="white--text headline"
              >{{ firstLetter(item.title) }}</span>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title> {{ computeTitle(item) }}</v-list-item-title>
              <v-list-item-subtitle>Some Latest message</v-list-item-subtitle>
            </v-list-item-content>
            <v-list-item-action>
              <v-list-item-action-text>
                {{ formatChatTime(item.created_at) }}
              </v-list-item-action-text>
              <v-circle
                dot
                small
                :color="chatStatusColor(item)"
              />
            </v-list-item-action>
          </v-list-item>
        </template>
      </v-list>
    </vue-perfect-scrollbar>
  </div>
</template>

<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import { Groups } from '../../api/chat';
import { getUserById } from '../../api/user';
import VCircle from '../circle/VCircle';
import Util from '../../util';

export default {
  components: {
    VuePerfectScrollbar,
    VCircle,
  },

  data: () => ({
    chats: Groups,
  }),

  methods: {
    chatRoute(id) {
      return `/chat/messaging/${id}`;
    },
    firstLetter(title) {
      return title.charAt(0);
    },
    formatChatTime(s) {
      return new Date(s).toLocaleDateString();
    },
    computeTitle(item) {
      const username = item.users.length === 1 ? getUserById(item.users[0]).username : '';
      return item.users.length === 1 ? username : item.title;
    },
    randomAvatarColor(item) {
      return item.users.length === 1 ? '' : Util.randomElement(['blue', 'indigo', 'success', 'error', 'pink']);
    },
    chatStatusColor() {
      return Util.randomElement(['blue', 'indigo', 'success', 'error', 'pink']);
    },
  },
};
</script>
