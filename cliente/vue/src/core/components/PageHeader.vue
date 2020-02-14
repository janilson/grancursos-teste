<template>
  <v-container
    fluid
    class="pb-0"
  >
    <v-breadcrumbs
      class="pa-0 pt-2"
      divider=">"
      :items="breadcrumbs"
    />
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      title: 'Home',
      breadcrumbs: [
      ],
    };
  },
  watch: {
    /* eslint-disable func-names */
    '$route.path': function () {
      this.computeBreadcrumbs();
    },
  },
  created() {
    this.computeBreadcrumbs();
  },
  methods: {
    computeBreadcrumbs() {
      const breadcrumbs = [
        {
          text: 'Home',
          href: '/',
          disabled: false,
        },
      ];
      let appends = [];
      appends = this.$route.matched
        .map(item => {
          if (!item.meta.title) {
            return null;
          }
          return {
            text: item.meta.title || '',
            href: item.path || '/',
            disabled: item.path === this.$route.path,
          };
        }).filter(item => item !== null);

      this.breadcrumbs = breadcrumbs.concat(appends);
    },
  },
};
</script>
<style lang="stylus" scoped>
  .disabled
    color: grey
    pointer-events: none
    text-decoration: blink
</style>
