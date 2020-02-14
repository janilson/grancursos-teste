<template>
  <div id="page-selects">
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
          xs="12"
        >
          <v-widget title="Single Selection">
            <div slot="widget-content">
              <v-container fluid>
                <v-row
                  row
                  wrap
                >
                  <v-col xs6>
                    <v-subheader>Standard</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e1"
                      :items="countries"
                      label="Select"
                      item-text="country"
                      item-value="abbr"
                      single-line
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Standard with focus</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e2"
                      :items="countries"
                      label="Select"
                      item-text="country"
                      item-value="abbr"
                      class="input-group--focused"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Error</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e3"
                      label="Select"
                      :items="countries"
                      :error-messages="['Please select an option']"
                      item-text="country"
                      item-value="abbr"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Prepend Icon</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e5"
                      label="Select"
                      prepend-icon="map"
                      :items="countries"
                      item-text="country"
                      item-value="abbr"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Append Icon</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e6"
                      label="Select"
                      :items="countries"
                      append-icon="map"
                      item-text="country"
                      item-value="abbr"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Auto complete</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="e7"
                      label="Select"
                      :items="countries"
                      autocomplete
                      item-text="country"
                      item-value="abbr"
                    />
                  </v-col>
                </v-row>
              </v-container>
            </div>
          </v-widget>
        </v-col>
        <v-col
          lg="6"
          xs="12"
        >
          <v-widget title="Mulitple Selection">
            <div slot="widget-content">
              <v-container fluid>
                <v-row
                  row
                  wrap
                >
                  <v-col xs6>
                    <v-subheader>Tags</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="multi1"
                      :items="countries"
                      tags
                      label="Select"
                      multi-line
                      item-text="country"
                      item-value="abbr"
                      return-object
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Tags and chips</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="multi2"
                      :items="countries"
                      tags
                      chips
                      multiple=""
                      label="Select"
                      class="input-group--focused"
                      item-text="country"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Rules</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="select"
                      label="Async items"
                      autocomplete
                      :loading="loading"
                      multiple
                      cache-items
                      chips
                      required
                      :items="items"
                      item-text="country"
                      item-value="country"
                      :rules="[() => select.length > 0 || 'You must choose at least one']"
                      :search-input.sync="search"
                    />
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Slots - Closable chips</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="multi4"
                      label="Select"
                      :items="countries"
                      chips
                      tags
                      multi-line
                      item-text="country"
                      item-value="abbr"
                      return-object
                    >
                      <template
                        slot="selection"
                        slot-scope="data"
                      >
                        <v-chip
                          :key="JSON.stringify(data.item.abbr)"
                          close
                          class="chip--select-multi"
                          :selected="data.selected"
                          @input="data.parent.selectItem(data.item.abbr)"
                        >
                          <v-avatar class="accent">
                            {{ data.item.abbr.slice(0, 1).toUpperCase() }}
                          </v-avatar>
                          {{ data.item.country }}
                        </v-chip>
                      </template>
                    </v-select>
                  </v-col>
                  <v-col xs6>
                    <v-subheader>Slots</v-subheader>
                  </v-col>
                  <v-col xs6>
                    <v-select
                      v-model="multi3"
                      label="Select"
                      :items="countries"
                      chips
                      tags
                      multi-line
                      item-text="country"
                      item-value="abbr"
                      return-object
                    >
                      <template
                        slot="selection"
                        slot-scope="data"
                      >
                        <v-chip
                          :key="JSON.stringify(data.item.abbr)"
                          class="chip--select-multi"
                          :selected="data.selected"
                          @input="data.parent.selectItem(data.item.abbr)"
                        >
                          <v-avatar class="accent">
                            {{ data.item.abbr.slice(0, 1).toUpperCase() }}
                          </v-avatar>
                          {{ data.item.country }}
                        </v-chip>
                      </template>
                    </v-select>
                  </v-col>
                </v-row>
              </v-container>
            </div>
          </v-widget>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import VWidget from '../../components/VWidget';
import Countries from '../../api/country';

export default {
  components: {
    VWidget,
  },
  data() {
    return {
      loading: false,
      items: [],
      search: null,
      select: [],
      e1: null,
      e2: null,
      e3: null,
      e4: null,
      e5: null,
      e6: null,
      e7: null,
      multi1: [],
      multi2: [],
      multi3: [],
      multi4: [],
      multi5: [],
      countries: Countries,
    };
  },
  computed: {},
  watch: {
    search(val) {
      /* eslint-disable no-unused-expressions */
      val && this.querySelections(val);
    },
  },
  methods: {
    querySelections(v) {
      this.loading = true;
      // Simulated ajax query
      setTimeout(() => {
        this.items = this.countries.filter(e => (e.country || '')
          .toLowerCase()
          .indexOf((v || '')
            .toLowerCase()) > -1);
        this.loading = false;
      }, 500);
    },
  },
};
</script>
