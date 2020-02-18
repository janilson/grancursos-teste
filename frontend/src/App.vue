<template>
    <v-app id="inspire">
        <v-app-bar
                app
                clipped-left
        >
            <v-toolbar-title>Application</v-toolbar-title>
        </v-app-bar>

        <v-content>
            <v-container
                    class="fill-height"
                    fluid
            >
                <v-row class="wi"
                        align="center"
                        justify="center"
                >
                    <v-col>
                        <v-form
                                ref="form"
                                v-model="valid"
                                lazy-validation
                        >
                            <v-select
                                    v-model="select"
                                    :items="items"
                                    :rules="[v => !!v || 'Item is required']"
                                    label="Assunto"
                                    required
                            ></v-select>

                            <v-btn
                                    :disabled="!valid"
                                    color="success"
                                    class="mr-4"
                                    @click="validate"
                            >
                                Validate
                            </v-btn>

                            <v-btn
                                    color="error"
                                    class="mr-4"
                                    @click="reset"
                            >
                                Reset Form
                            </v-btn>

                            <v-btn
                                    color="warning"
                                    @click="resetValidation"
                            >
                                Reset Validation
                            </v-btn>
                        </v-form>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>

        <v-footer app>
            <span>&copy; Janilson Mendes</span>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        props: {
            source: String,
        },
        data: () => ({
            drawer: false,
        }),
        created() {
            // this.$vuetify.theme.dark = true
        },
    }
</script>