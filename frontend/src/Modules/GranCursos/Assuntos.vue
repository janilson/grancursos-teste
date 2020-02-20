<template>
    <v-content>
        <v-container
                class="fill-height"
                fluid
        >
            <v-row
                    align="center"
                    justify="center"
            >
                <v-col
                        cols="12"
                        sm="8"
                        md="8"
                >
                    <v-card class="elevation-12">
                        <v-toolbar
                                color="primary"
                                dark
                                flat
                        >
                            <v-toolbar-title>Pesquisa de Assuntos</v-toolbar-title>
                            <v-spacer/>
                        </v-toolbar>
                        <v-card-text>
                            <v-form
                                    lazy-validation
                                    ref="form"
                            >
                                <v-row>
                                    <v-col cols="6">
                                        <v-select
                                                v-model="formulario.id_banca"
                                                :items="bancas"
                                                item-value="id_banca"
                                                item-text="no_banca"
                                                label="Banca"
                                                :rules="[rules.required]"
                                                required
                                        />
                                    </v-col>
                                    <v-col cols="6">
                                        <v-select
                                                v-model="formulario.id_orgao"
                                                :items="orgaos"
                                                item-value="id_orgao"
                                                item-text="no_orgao"
                                                label="Orgão"
                                                :rules="[rules.required]"
                                                required
                                        />
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn
                                    color="primary"
                                    class="mr-20"
                                    @click="limpar"
                            >
                                Limpar
                            </v-btn>
                            <v-btn
                                    color="primary"
                                    class="mr-20"
                                    @click="pesquisar"
                            >
                                Pesquisar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>

            <v-row
                    align="center"
                    justify="center"
            >
                <v-col
                        cols="12"
                        sm="8"
                        md="8"
                >
                    <v-card>
                        <v-divider/>
                        <v-list>
                            <v-list-group
                                    v-for="assunto in assuntos"
                                    v-bind:key="assunto.id_assunto"
                            >
                                <template v-slot:activator>
                                    <v-list-item-title>
                                        <h3>
                                            <span float-left class="blue-grey--text">
                                                {{assunto.no_assunto}} - Nº Questões({{assunto.nu_total_questoes}})
                                            </span>
                                        </h3>
                                    </v-list-item-title>
                                </template>
                                <v-list-group
                                        no-action
                                        sub-group
                                        style="margin-left: 10px;"
                                        v-for="nivel2 in assunto.filhos"
                                        v-bind:key="nivel2.id_assunto"
                                >
                                    <template v-slot:activator v-if="assunto.filhos.length > 0">
                                        <v-list-item-title>
                                            <h4>
                                                <span class="green--text">
                                                    {{nivel2.no_assunto}} - Nº Questões({{nivel2.nu_total_questoes}})
                                                </span>
                                            </h4>
                                        </v-list-item-title>
                                    </template>
                                    <v-list-group
                                            no-action
                                            sub-group
                                            style="margin-left: 30px;"
                                            v-for="nivel3 in nivel2.netos"
                                            v-bind:key="nivel3.id_assunto"
                                    >
                                        <template v-slot:activator>
                                            <v-list-item-title>
                                                <h5>
                                                    <span class="red--text">
                                                        {{nivel3.no_assunto}} - Nº Questões({{nivel3.nu_total_questoes}})
                                                    </span>
                                                </h5>
                                            </v-list-item-title>
                                        </template>
                                    </v-list-group>
                                </v-list-group>
                            </v-list-group>
                        </v-list>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-content>
</template>

<script>
    import {mapActions} from 'vuex';

    export default {
        name: 'Assuntos',
        data: () => ({
            assuntos: [],
            bancas: [],
            orgaos: [],
            formulario: {
                id_banca: null,
                id_orgao: null
            },
            nivel1: [
                {text: 'Assunto Principal', value: 'no_assunto', sortable: false},
                {text: 'Nº Questões', value: 'nu_total_questoes', sortable: false},
                {text: '', value: 'data-table-expand'}
                // {text: 'Questoes', value: 'questoes', sortable: false}
            ],
            nivel2: [
                {text: 'Assunto Nível 2', value: 'no_assunto', sortable: false},
                {text: 'Nº Questões', value: 'nu_total_questoes', sortable: false},
                {text: '', value: 'data-table-expand'}
            ],
            nivel3: [
                {text: 'Assunto Nível 3', value: 'no_assunto', sortable: false},
                {text: 'Nº Questões', value: 'nu_total_questoes', sortable: false},
            ],
            rules: {
                required: v => !!v || "Campo não preenchido",
            },
            expanded: [],
            singleExpand: false
        }),
        methods: {
            ...mapActions({
                listarAssuntos: 'GranCursos/listarAssuntos',
                listarBancas: 'GranCursos/listarBancas',
                listarOrgaos: 'GranCursos/listarOrgaos'
            }),

            pesquisar() {
                if (!this.$refs.form.validate()) {
                    return false;
                }

                this.assuntos = [];
                this.listarAssuntos(this.formulario).then((data) => {
                    this.assuntos = data;
                });
            },

            limpar() {
                this.formulario = {
                    id_banca: null,
                    id_orgao: null,
                };
                this.$refs.form.reset();
                this.assuntos = [];
            }
        },
        mounted() {
            this.listarBancas().then((data) => {
                this.bancas = data;
            });

            this.listarOrgaos().then((data) => {
                this.orgaos = data;
            });
        }
    };
</script>
