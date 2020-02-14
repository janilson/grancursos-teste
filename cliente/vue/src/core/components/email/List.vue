<template>
  <v-container
    id="mailList"
    fluid
    fill-height
    class="pa-0 mail-list"
  >
    <v-row
      column
      class="mail-list--layout"
    >
      <v-toolbar
        fixed
        app
        class="elevation-1 mail-list--toolbar"
      >
        <v-checkbox
          row
          hide-details
          class="check-all"
        />
        <v-menu
          offset-y
          origin="center center"
          :nudge-bottom="0"
          transition="scale-transition"
        >
          <v-btn
            slot="activator"
            icon
            large
            text
          >
            <v-avatar size="32px">
              <v-icon>arrow_drop_down</v-icon>
            </v-avatar>
          </v-btn>
          <v-list class="pa-0">
            <v-list-item
              v-for="(item, index) in mailActions"
              :key="index"
              :to="!item.href ? { name: item.name } : null"
              :href="item.href"
              ripple="ripple"
              :disabled="item.disabled"
              :target="item.target"
              rel="noopener"
              @click="item.click"
            >
              <v-list-item-action v-if="item.icon">
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>{{ item.title }}</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-menu>
        <v-spacer />
        <v-btn
          icon
          text
        >
          <v-icon>refresh</v-icon>
        </v-btn>
        <v-btn
          icon
          text
        >
          <v-icon>keyboard_arrow_left</v-icon>
        </v-btn>
        <v-btn
          icon
          text
        >
          <v-icon>keyboard_arrow_right</v-icon>
        </v-btn>
      </v-toolbar>
      <vue-perfect-scrollbar class="mail-list--scrollbar">
        <v-col class="mail-content white">
          <v-tabs
            fixed-tabs
            grow
          >
            <v-tab>
              Primary
            </v-tab>
            <v-tab>
              Social
            </v-tab>
            <v-tab>
              Promotions
            </v-tab>
          </v-tabs>
          <v-list
            two-line
            class="mail-list--list"
          >
            <template v-for="(item, index) in mails">
              <v-list-item
                :key="index"
                avatar
                ripple
                :to="computeMailPath(item.uuid)"
              >
                <v-list-item-action>
                  <v-checkbox />
                </v-list-item-action>
                <v-list-item-avatar>
                  <img :src="item.from.avatar">
                </v-list-item-avatar>
                <v-list-item-content>
                  <v-list-item-title>{{ item.from.name }}</v-list-item-title>
                  <v-list-item-subtitle>{{ item.title }}</v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                  <v-list-item-action-text>{{ formatDate(item.created_at) }}</v-list-item-action-text>
                  <v-icon
                    v-if="selected.indexOf(index) < 0"
                    color="grey lighten-1"
                    @click="toggle(index)"
                  >
                    star_border
                  </v-icon>
                  <v-icon
                    v-else
                    color="yellow darken-2"
                  >
                    star
                  </v-icon>
                </v-list-item-action>
              </v-list-item>
              <v-divider :key="'divider' + index" />
            </template>
          </v-list>
        </v-col>
      </vue-perfect-scrollbar>
    </v-row>
  </v-container>
</template>
<script>
import VuePerfectScrollbar from 'vue-perfect-scrollbar';
import { getMailByType } from '../../api/mail';

export default {
  components: {
    VuePerfectScrollbar,
  },
  props: {
    mailType: {
      type: String,
      default: 'All',
    },
  },
  data: () => ({
    selected: [2],
    mailActions: [
      {
        href: '#',
        title: 'Delete',
        click: () => {
        },
      },
      {
        href: 'Mark as read',
        title: 'Mark as read',
        click: () => {
        },
      },
      {
        href: 'Spam',
        title: 'Spam',
        click: () => {
        },
      },
    ],
  }),
  computed: {
    mails() {
      return getMailByType(this.$route.params.mailType);
    },
  },

  created() {
    this.$on('MAIL_REPLY_DIALOG_CLOSE', () => {
      this.replayDialog = false;
    });
    window.AppMail = this;
  },
  methods: {
    computeMailPath(id) {
      return { path: `/mail/0/${id}` };
    },
    formatDate(s) {
      return new Date(s).toLocaleString();
    },

    toggle(index) {
      const i = this.selected.indexOf(index);
      if (i > -1) {
        this.selected.splice(i, 1);
      } else {
        this.selected.push(index);
      }
    },
  },
};
</script>
