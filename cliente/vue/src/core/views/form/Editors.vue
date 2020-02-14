<template>
  <div id="pageEditor">
    <v-container
      grid-list-xl
      fluid
    >
      <v-row
        row
        wrap
      >
        <v-col sm="12">
          <h3 class="pa-0">
            Awesome Quill Editor &nbsp;&nbsp;<a href="https://quilljs.com">Offical Website</a>
          </h3>
        </v-col>
        <v-col sm="12">
          <quill-editor
            class="quill"
            :content="content"
            :options="editorOption"
          />
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
/* eslint-disable import/extensions */
import { quillEditor } from 'vue-quill-editor';

export default {
  components: {
    quillEditor,
  },
  data() {
    return {
      content: 'Compose Epic Story...',
      editorOption: {},
    };
  },
  computed: {},

  methods: {},
};
</script>
<style lang="stylus" scoped>
.quill
  height : 520px
</style>
