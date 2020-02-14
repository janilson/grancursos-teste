<?php

namespace Modules\Inscricao\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class ItemTableSeeder extends Seeder
{
    const CO_GRUPO = 'co_grupo';
    const DS_FORMULARIO_ITEM_INSCRICAO = 'ds_formulario_item_inscricao';
    const NU_PONTUACAO = 'nu_pontuacao';
    const CO_FORMULARIO_ITEM_INSC_PAI = 'co_formulario_item_insc_pai';
    const TP_FORMULARIO_ITEM_INSCRICAO = 'tp_formulario_item_inscricao';
    const NU_ORDEM = 'nu_ordem';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * GRUPO 0
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 0,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Nos termos do artigo 11 da Portaria nº 2.031, de 17 de Outubro de 2019, e da Cláusula Segunda do Termo de Adesão assinado pelo(a) prefeito(a), confirmo que o município:',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'P',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 0,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Aderiu ao Plano Progredir;',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 1,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 0,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Aderiu ao Programa Criança Feliz ou, caso não seja elegível, manifesta intenção de aderir quando contemplado;',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 1,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 3
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 0,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Compromete-se a realizar diagnóstico acerca da situação dos dependentes químicos em tratamento no município; e',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 1,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 4
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 0,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Realizou compras institucionais da agricultura familiar (anexar comprovante).',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 1,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 5
            ],
        ]);

        /*
         * GRUPO 1
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município realizou as etapas municipais dos Jogos Escolares (um ponto)',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);
        
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'Modalidades propostas: atletismo, basquete, futsal, handebol, vôlei e xadrez (um ponto por item):',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'P',
                self::NU_ORDEM => 2
            ],
        ]);
        
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) EXTRA 1: O município realizou os Jogos com pelo menos três das modalidades propostas (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 7,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 3
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) EXTRA 2: O município realizou os Jogos nas seis modalidades propostas (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 7,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 4
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) EXTRA 3: O município viabilizou a participação dos atletas classificados na etapa municipal e, quando aplicável, nos Jogos Escolares Estaduais ou Nacionais (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 7,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 5
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município realizou evento de esporte e lazer com o objetivo de integrar a comunidade, conscientizar sobre os benefícios da atividade física e valorizar a cultura popular, como jogos e brincadeiras tradicionais de cada região (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 7,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 6
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) EXTRA: O município aderiu aos seguintes programas da Secretaria Especial do Esporte (um ponto por programa):',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'P',
                self::NU_ORDEM => 7
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '1. Eventos e competições de participação (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 8
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '2. Programa Esporte e Lazer da Cidade - PELC (Núcleo Urbano/Povos Indígenas e Comunidades Tradicionais) (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 9
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '3. Programa Segundo Tempo - PST (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 10
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '4. Programa Vida Saudável (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 11
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '5. Programa Luta pela Cidadania (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 12
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '6. Projeto Iniciação e Aprimoramento de Modalidade Esportiva (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 13
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '7. Projeto Esporte e Cidadania  (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 14
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '8. Projeto Virando o Jogo (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 15
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '9. Projeto DELAS (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 16
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 1,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '10. Brincando com Esporte (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 12,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 17
            ],
        ]);

        /*
         * GRUPO 2
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município realizou ações culturais: festivais, shows, eventos, exposições, festejos populares, datas comemorativas, projetos de inclusão, oficinas e outras atividades que promovam à cultura no município, nos diversos segmentos culturais, nas seguintes categorias (um ponto por categoria):',
                self::NU_PONTUACAO => 0,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'P',
                self::NU_ORDEM => 1
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '1. Artes cênicas: teatro, circo, dança (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '2. Artes visuais: artes plásticas (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 3
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '3. Música: canto popular, canto coral, bandas, bandas escolares e orquestras populares e/ou eruditas (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 4
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '4. Audiovisual: produção, jogos eletrônicos, difusão de conteúdo (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 5
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '5. Patrimônio: catalogação, preservação (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 6
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => '6. Museu e memória: exposições, segurança, preservação, manutenção, criação de espaços musicais (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 7
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) EXTRA 1: o município tem banda escolar ativa (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 8
            ],
        ]);
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 2,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) EXTRA 2: o município tem orquestra em funcionamento (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => 23,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
         * GRUPO 3
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 3,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município tem biblioteca pública em funcionamento (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 3,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município realizou Feiras Literárias e Ações de Incentivo à Leitura (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
        * GRUPO 4
        */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 4,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município realizou ações integradas nas áreas da cultura, do esporte e do desenvolvimento social, em espaços comunitários, espaços públicos e/ou privados, centros de convivência e demais áreas disponíveis no município, que comportem essas práticas dentro de padrões de qualidade e segurança, com foco na juventude e nas pessoas idosas (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 4,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município ampliou a quantidade de escolas municipais com atividades no contra turno (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
        * GRUPO 5
        */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 5,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município realizou adesão, em 2019, ao Programa Criança Feliz (dois pontos); ou',
                self::NU_PONTUACAO => 2,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 5,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município alcançou o mínimo de 30% da meta pactuada para o atendimento no Programa Criança Feliz para os municípios que realizaram a adesão em anos anteriores (dois pontos).',
                self::NU_PONTUACAO => 2,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
        * GRUPO 6
        */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 6,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município utilizou pelo menos 30% (trinta por cento) do total dos recursos financeiros repassados pelo FNDE, no âmbito do Programa Nacional de Alimentação Escolar (PNAE), na aquisição de gêneros alimentícios diretamente da agricultura familiar, comprovado pelos últimos dados consolidados disponibilizados no site do FNDE (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 6,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município adquiriu gêneros alimentícios diretamente da agricultura familiar,  utilizando recursos próprios do município, para atendimento de suas demandas alimentícias (dois pontos).',
                self::NU_PONTUACAO => 2,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
       * GRUPO 7
       */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 7,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município realizou Campanha de Prevenção ao uso de tabaco, álcool e outras drogas (um ponto);',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 7,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) O município levantou junto ao Sistema Único de Saúde (SUS), Sistema Único da Assistência Social (SUAS) e Sistema Nacional de Políticas Públicas sobre Drogas (SISNAD), entre outros, o número de dependentes químicos em tratamento no município e as drogas prevalentes (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        /*
         * GRUPO 8
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 8,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) O município atingiu percentual mínimo de 1% de jovens inscritos no Cadastro Único matriculados nos cursos profissionalizantes ofertados pelo Sistema S ou demais cursos presentes no Plano Progredir (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        /*
         * GRUPO 9
         */
        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 9,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'a) Pelo menos uma das ações realizadas, de qualquer um dos grupos, utilizou recursos de emenda parlamentar.',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 1
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 9,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'b) Pelo menos uma das ações realizadas, de qualquer um dos grupos, utilizou recursos da Lei de Incentivo ao Esporte ou da Lei de Incentivo à Cultura.',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 2
            ],
        ]);

        \DB::table('tb_formulario_item_inscricao')->insert([
            [
                self::CO_GRUPO => 9,
                self::DS_FORMULARIO_ITEM_INSCRICAO => 'c) O município aderiu às atividades do Programa Nacional de Incentivo ao Voluntariado, conforme art. 12, § 5º, da Portaria nº 2.031 de 17/10/2019 (um ponto).',
                self::NU_PONTUACAO => 1,
                self::CO_FORMULARIO_ITEM_INSC_PAI => NULL,
                self::TP_FORMULARIO_ITEM_INSCRICAO => 'R',
                self::NU_ORDEM => 3
            ],
        ]);
    }
}