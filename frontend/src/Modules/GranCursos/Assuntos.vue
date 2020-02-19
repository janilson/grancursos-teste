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
                            <v-form lazy-validation
                                    refs="form">
                                <v-row>
                                    <v-col cols="6">
                                        <v-select
                                                v-model="formulario.id_banca"
                                                :items="bancas"
                                                item-value="id_banca"
                                                item-text="no_banca"
                                                :rules="[v => !!v || 'Banca é obrigatório']"
                                                label="Banca"
                                                required
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-select
                                                v-model="formulario.id_orgao"
                                                :items="orgaos"
                                                item-value="id_orgao"
                                                item-text="no_orgao"
                                                :rules="[v => !!v || 'Orgão é obrigatório']"
                                                label="Orgão"
                                                required
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn color="primary">Login</v-btn>
                        </v-card-actions>
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
            }
        }),
        methods: {
            ...mapActions({
                listarAssuntos: 'GranCursos/listarAssuntos',
                listarBancas: 'GranCursos/listarBancas',
                listarOrgaos: 'GranCursos/listarOrgaos'
            }),
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
