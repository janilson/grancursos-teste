<template>
  <div id="page-statistic">
    <v-container
      grid-list-xl
      fluid
    >
      <v-row
        row
        wrap
      >
        <v-col sm="12">
          <h4>Social</h4>
        </v-col>
        <!-- mini statistic start -->
        <v-col
          lg="3"
          sm="6"
          xs="12"
        >
          <mini-statistic
            icon="fa fa-facebook"
            title="100+"
            sub-title="Likes"
            color="indigo"
          />
        </v-col>
        <v-col
          lg="3"
          sm="6"
          xs="12"
        >
          <mini-statistic
            icon="fa fa-google"
            title="150+"
            sub-title="Connections"
            color="red"
          />
        </v-col>
        <v-col
          lg="3"
          sm="6"
          xs="12"
        >
          <mini-statistic
            icon="fa fa-twitter"
            title="200+"
            sub-title="Followers"
            color="light-blue"
          />
        </v-col>
        <v-col
          lg="3"
          sm="6"
          xs="12"
        >
          <mini-statistic
            icon="fa fa-instagram"
            title="50+"
            sub-title="Shots"
            color="purple"
          />
        </v-col>
        <!-- linear statistic  end -->
        <v-col sm="12">
          <h4>Linear Trending</h4>
        </v-col>
        <v-col
          v-for="(item, index) in trending"
          :key="'trending' + index"
          lg="4"
          sm="12"
        >
          <linear-statistic
            :title="item.subheading"
            :sub-title="item.caption"
            :icon="item.icon.label"
            :color="item.icon.color"
            :value="item.linear.value"
          />
        </v-col>
        <!-- circle statistic  end -->
        <v-col sm="12">
          <h4>Circle Trending</h4>
        </v-col>
        <v-col
          v-for="(item, index) in trending2"
          :key="'c-trending' + index"
          lg="4"
          sm="12"
        >
          <circle-statistic
            :title="item.subheading"
            :sub-title="item.headline"
            :caption="item.caption"
            :icon="item.icon.label"
            :color="item.linear.color"
            :value="item.linear.value"
          />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import MiniStatistic from '../../components/widgets/statistic/MiniStatistic';
import LinearStatistic from '../../components/widgets/statistic/LinearStatistic';
import CircleStatistic from '../../components/widgets/statistic/CircleStatistic';

export default {
  components: {
    CircleStatistic,
    MiniStatistic,
    LinearStatistic,
  },
  data() {
    return {
      trending: [
        {
          subheading: 'Sales',
          headline: '2,55',
          caption: 'increase',
          percent: 15,
          icon: {
            label: 'trending_up',
            color: 'success',
          },
          linear: {
            value: 15,
            color: 'success',
          },
        },
        {
          subheading: 'Revenue',
          headline: '6,553',
          caption: 'increase',
          percent: 10,
          icon: {
            label: 'trending_down',
            color: 'error',
          },
          linear: {
            value: 15,
            color: 'error',
          },
        },
        {
          subheading: 'Orders',
          headline: '5,00',
          caption: 'increase',
          percent: 50,
          icon: {
            label: 'arrow_upward',
            color: 'info',
          },
          linear: {
            value: 50,
            color: 'info',
          },
        },
      ],
      trending2: [
        {
          subheading: 'Email',
          headline: '15+',
          caption: 'email opens',
          percent: 15,
          icon: {
            label: 'email',
            color: 'info',
          },
          linear: {
            value: 15,
            color: 'info',
          },
        },
        {
          subheading: 'Tasks',
          headline: '90%',
          caption: 'tasks completed.',
          percent: 90,
          icon: {
            label: 'list',
            color: 'primary',
          },
          linear: {
            value: 90,
            color: 'success',
          },
        },
        {
          subheading: 'Issues',
          headline: '100%',
          caption: 'issues fixed.',
          percent: 100,
          icon: {
            label: 'bug_report',
            color: 'primary',
          },
          linear: {
            value: 100,
            color: 'error',
          },
        },
      ],
    };
  },
};
</script>
<style lang="stylus" scoped></style>
