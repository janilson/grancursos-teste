<template>

  <v-row>
    <v-col cols="10">
      <v-expansion-panels class="mt-6">
        <v-expansion-panel
          v-for="item in grupos"
        >
          <div v-if="item">
            <v-expansion-panel-header>
              <span class="font-weight-bold">
                <span v-if="item.co_grupo !== 0 && item.co_grupo !== 9">{{ `Grupo ${item.co_grupo} - `}}</span>
                {{ item.ds_grupo }}
              </span>
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <template v-for="grupo in item.perguntas" v-if="item.perguntas">
                <div
                  class="v-input ml-4 theme--light v-input--selection-controls v-input--checkbox font-weight-bold"
                  v-if="(grupo.tp_item === 'P')">
                  <div class="v-input__control">
                    <div class="v-messages theme--light" v-if="(grupo.cod > 0)"></div>
                    <div class="v-messages theme--light" v-if="(grupo.cod > 0)"></div>
                    <div class="v-input__slot">
                      {{ grupo.label }}
                    </div>
                  </div>
                </div>
                <v-checkbox
                  :disabled="grupo.disabled"
                  :key="grupo.co_formulario_item_inscricao"
                  :label="grupo.label"
                  :value="grupo.st_resposta"
                  class="ml-4 font-weight-regular"
                  v-else
                  v-model="grupo.st_resposta"
                />
              </template>
              <div
                class="v-input theme--light v-input--selection-controls v-input--checkbox font-weight-bold"
                v-if="(0 === item.co_grupo && dadosEnvio.coArquivo)">
                <v-card-text class="text-center">
                  {{ dadosEnvio.noArquivo }}
                  <v-icon
                    @click="abrirArquivo()"
                    color="blue darken-4"
                    right
                    size="32px"
                    title="Fazer o download do arquivo"
                  >
                    cloud_download
                  </v-icon>

                </v-card-text>
              </div>
            </v-expansion-panel-content>
          </div>
        </v-expansion-panel>
      </v-expansion-panels>

    </v-col>

    <v-col class="mt-6" cols="2">
      <v-card style="position: fixed">
        <v-card-text>
          <div class="text-center font-weight-medium red--text">Soma total de pontos:
            <div class="subheading font-weight-black">{{ pontuacaoTotal }}</div>
          </div>
          <br/>
          <hr class="font-weight-thin primary"/>
          <br/>
          <div class="text-center font-weight-medium">
            Situação:
            <div class="subheading font-weight-black green--text" v-if="dadosEnvio.noUsuarioEnvio">
              Enviado
            </div>
            <div class="subheading font-weight-black red--text" v-else>
              Pendente
            </div>
          </div>

          <div class="text-left font-weight-medium" v-if="dadosEnvio.noUsuarioEnvio">
            <br/>
            <hr class="font-weight-thin primary"/>
            <br/>
            <div class="text-center font-weight-bold">Último Envio</div>
            <br/>
            Nome:
            <span class="subheading font-weight-black primary--text">
                {{ dadosEnvio.noUsuarioEnvio }}
              </span>
            <br/>
            CPF:
            <span class="subheading font-weight-black primary--text">
                {{ dadosEnvio.nuCpfEnvio | mxFiltroFormatarCPFCNPJ}}
              </span>
            <br/>
            Data:
            <span class="subheading font-weight-black primary--text">
                {{ dadosEnvio.dtEnvio }} às {{ dadosEnvio.hrEnvio }}
            </span>
          </div>
        </v-card-text>
      </v-card>
    </v-col>

  </v-row>
</template>
<script>
    import {mapActions} from 'vuex';
    import MxFiltros from '@/modules/shared/mixins/filters';

    export default {
        mixins: [
            MxFiltros,
        ],
        name: 'AccordionGrupos',
        props: {
            grupos: {
                type: Array,
                required: true
            },
            pontuacaoTotal: {
                type: Number,
                required: true
            },
            dadosEnvio: {
                type: Object,
                required: true
            }
        },
        methods: {
            ...mapActions({
                downloadArquivo: 'shared/downloadArquivo',
            }),
            abrirArquivo() {
                this.downloadArquivo(this.dadosEnvio.coArquivo)
            }
        },
        data() {
            return {}
        },
    }
</script>
