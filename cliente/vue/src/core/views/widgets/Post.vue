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
        <v-col lg="6">
          <message-list />
        </v-col>
        <v-col lg="6">
          <notification-list />
        </v-col>
        <v-col lg="6">
          <plain-table />
        </v-col>
        <v-col lg="6">
          <plain-table-order />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import MessageList from '../../components/widgets/list/MessageList';
import NotificationList from '../../components/widgets/list/NotificationList';
import PlainTable from '../../components/widgets/list/PlainTable';
import PlainTableOrder from '../../components/widgets/list/PlainTableOrder';

export default {
  components: {
    MessageList,
    NotificationList,
    PlainTable,
    PlainTableOrder,
  },
  data() {
    return {};
  },
  methods: {
    handleClick: () => {
    },
  },
};
</script>
