<template>
  <div id="page-forms">
    <v-container
      grid-list-xl
      fluid
    >
      <v-row
        row
        wrap
      >
        <v-col lg="6">
          <v-card class="mb-4">
            <v-toolbar
              color="teal"
              dark
              flat
              dense
            >
              <v-toolbar-title class="subheading">
                Payment Form with validation
              </v-toolbar-title>
              <v-spacer />
            </v-toolbar>
            <v-divider />
            <v-card-text class="">
              <payment-form />
            </v-card-text>
          </v-card>
          <v-card>
            <v-toolbar
              color="success"
              dark
              flat
              dense
            >
              <v-toolbar-title class="subheading">
                Ship Form
              </v-toolbar-title>
              <v-spacer />
            </v-toolbar>
            <v-divider />
            <v-card-text class="">
              <shipment-form />
            </v-card-text>
          </v-card>
        </v-col>
        <v-col lg="6">
          <event-form />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import EventForm from '../../components/widgets/form/EventForm';
import PaymentForm from '../../components/widgets/form/PaymentForm';
import ShipmentForm from '../../components/widgets/form/ShipmentForm';

export default {
  components: {
    PaymentForm,
    ShipmentForm,
    EventForm,
  },
  data() {
    return {};
  },
  computed: {},
  methods: {},
};
</script>
