<template>
  <div id="social">
    <v-container
      grid-list-xl
      fluid
    >
      <v-row
        row
        wrap
      >
        <v-col
          lg="6"
          sm="12"
          xs="12"
        >
          <message-list />
        </v-col>
        <v-col
          lg="6"
          sm="12"
          xs="12"
        >
          <notification-list />
        </v-col>
        <v-col
          lg="7"
          sm="12"
          xs="12"
        >
          <plain-table />
        </v-col>
        <v-col
          lg="5"
          sm="12"
          xs="12"
        >
          <plain-table-order />
        </v-col>
        <v-col
          lg="12"
          sm="12"
          xs="12"
        >
          <post-list-card :items="posts" />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { getPost } from '../../api/post';
import MessageList from '../../components/widgets/list/MessageList';
import NotificationList from '../../components/widgets/list/NotificationList';
import PlainTable from '../../components/widgets/list/PlainTable';
import PlainTableOrder from '../../components/widgets/list/PlainTableOrder';
import PostListCard from '../../components/widgets/card/PostListCard';

export default {
  components: {
    PostListCard,
    MessageList,
    NotificationList,
    PlainTable,
    PlainTableOrder,
  },
  data() {
    return {};
  },
  computed: {
    posts() {
      return getPost();
    },
  },
  methods: {
    handleClick: () => {},
  },
};
</script>
