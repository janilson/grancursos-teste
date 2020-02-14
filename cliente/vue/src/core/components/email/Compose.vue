<template>
  <v-card>
    <v-toolbar
      color="primary"
      dark
    >
      <v-icon color="white">
        arrow_back
      </v-icon>
      <v-toolbar-title class="font-weight-light">
        Compose
      </v-toolbar-title>
      <v-spacer />
      <v-btn icon>
        <v-icon color="white">
          send
        </v-icon>
      </v-btn>
    </v-toolbar>
    <v-container
      fluid
      class="pa-0 mt-2"
    >
      <v-row wrap>
        <v-col xs2>
          <v-subheader>To</v-subheader>
        </v-col>
        <v-col
          xs10
          class="text-right"
        >
          <v-chip>
            <v-avatar>
              <img src="https://randomuser.me/api/portraits/men/92.jpg">
            </v-avatar>
            Trevor Hansen
          </v-chip>
          <v-chip>
            <v-avatar>
              <img src="https://randomuser.me/api/portraits/men/91.jpg">
            </v-avatar>
            Alex Nelson
          </v-chip>
        </v-col>
        <v-divider />
        <v-col xs2>
          <v-subheader>CC</v-subheader>
        </v-col>
        <v-col
          xs10
          class="text-right"
        >
          <v-chip>
            <v-avatar>
              <img src="https://randomuser.me/api/portraits/men/92.jpg">
            </v-avatar>
            John Doe
          </v-chip>
        </v-col>
        <v-col xs="12">
          <v-divider />
          <v-text-field
            label="Subject"
            value="Plans for the weekend"
            single-line
            full-width
            hide-details
          />
        </v-col>
        <v-col xs="12">
          <v-divider />
          <v-text-field
            v-model="title"
            label="Message"
            counter
            max="120"
            full-width
            multi-line
            single-line
          />
        </v-col>
      </v-row>
    </v-container>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    title:
      'Hi,\nI just wanted to check in',
  }),
};
</script>
