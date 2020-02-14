<!DOCTYPE html>
<html lang="pt-br">
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">
    <style>
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Extra personal styles **/
            text-align: center;
            line-height: 0.5cm;
        }

        body {
            margin-top: 2.5cm;
        }
    </style>
</head>
<body>
<header>
    <table style="width: 100%">
        <tr>
            <td style="width: 33%">
                <img width="200px" src="{{base_path()}}/public/img/mini_logo_mais_cidadao.png"/>
            </td>
            <td style="width: 33%;text-align: center">
                <img height="70px" src="{{base_path()}}/public/img/brasao.png"/>
            </td>
            <td style="width: 33%"></td>
        </tr>
        <tr>
            <td style="width: 33%"></td>
            <td style="width: 33%;text-align: center">
                MINISTÉRIO DA CIDADANIA
            </td>
            <td style="width: 33%"></td>
        </tr>
    </table>
</header>

<main>
    <p style="text-align: justify">
        O município {{ $adesao->municipio->no_municipio  }}, neste ato representado pelo(a)
        Prefeito(a) {{ $adesao->no_prefeito  }},
        adere ao Programa Município Mais Cidadão, nos termos da Portaria nº 2.031/GM/MC, obrigando-se a observar a
        legislação
        cabível, bem como os termos e as condições a seguir aduzidas.
    </p>

    <div style="text-align: center; font-weight: bold">
        TERMOS E CONDIÇÕES
    </div>

    <p>
        <span style="font-weight: bold; text-align: justify">Cláusula Primeira:</span> O
        município {{ $adesao->municipio->no_municipio }} colaborará com o Estado ao qual está circunscrito e com a
        União na execução integrada das ações do Programa Município Mais Cidadão, nos termos da legislação aplicável e
        deste instrumento.
    </p>
    <p>
        <span style="font-weight: bold; text-align: justify">Cláusula Segunda:</span> Compromete-se o município a, sem
        prejuízo de outras ações que se façam necessárias à plena execução
        do Programa Município Mais Cidadão:
    <p>
        I - Aderir ao programa Progredir;
    </p>
    <p style="text-align: justify">
        II - Aderir ao Programa Criança Feliz, caso o município seja elegível, conforme Resolução nº 7, de 22 de maio de
        2017 do Conselho Nacional de Assistência Social;
    </p>
    <p style="text-align: justify">
        III - Comprovar, até a primeira rodada de avaliação, da existência de compras institucionais feitas da
        agricultura familiar; e
    </p>
    <p style="text-align: justify">
        IV - Realizar diagnóstico acerca da situação dos dependentes químicos em tratamento no município que inclua, no
        mínimo, número estimado de dependentes químicos em tratamento e de drogas mais presentes.
    </p>
    </p>
    <p style="text-align: justify">
        <span style="font-weight: bold">Cláusula Terceira:</span> A vigência deste termo será de quatro anos,
        prorrogável por igual período.
    </p>
    <p style="text-align: justify">
        <span style="font-weight: bold">Cláusula Quarta:</span> A adesão ao Programa Município Mais Cidadão é
        voluntária, podendo ser denunciada pelo ente federado mediante comunicação oficial com antecedência mínima de
        trinta dias ou rescindido por qualquer das partes por descumprimento dos termos e condições do Programa.
    </p>
    <p style="text-align: justify">
        <span style="font-weight: bold">Cláusula Quinta:</span> O presente termo de adesão não envolve a transferência
        de recursos orçamentários e financeiros entre os entes.
    </p>
    <p style="text-align: justify">
        <span style="font-weight: bold">Cláusula Sexta:</span> O foro para dirimir quaisquer questões oriundas da adesão
        ao Programa Município Mais Cidadão é o da Circunscrição Judiciária de Brasília, Distrito Federal.
    </p>
    <p style="text-align: justify">
        <span style="font-weight: bold">Cláusula Sétima:</span> Os três servidores abaixo designados estão autorizados a
        inscrever o município na premiação do Programa Município Mais Cidadão e a atuar como pontos focais para demais
        questões em relação ao Programa:
    </p>

    <table>
        <tr>
            @for($numServidor = 0; $numServidor < 3; $numServidor++)
                <td style="width: 230px;vertical-align: top;">
                    <table style="width: 200px;border-collapse: collapse;">
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">CPF</td>
                            <td style="border: 1px solid black;padding: 3px;">
                                @cpf_formatado($adesao->servidores[$numServidor]->nu_cpf)
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">Nome</td>
                            <td style="border: 1px solid black;padding: 3px;">{{ $adesao->servidores[$numServidor]->no_servidor }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">E-mail</td>
                            <td style="border: 1px solid black;padding: 3px;">
                                @quebra_email($adesao->servidores[$numServidor]->ds_email)
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">Telefone</td>
                            <td style="border: 1px solid black;padding: 3px;">
                                @telefone_formatado($adesao->servidores[$numServidor]->nu_telefone)
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">Cargo</td>
                            <td style="border: 1px solid black;padding: 3px;">{{ $adesao->servidores[$numServidor]->no_funcao }}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black;padding: 3px;">Lotação</td>
                            <td style="border: 1px solid black;padding: 3px;">{{ $adesao->servidores[$numServidor]->no_lotacao }}</td>
                        </tr>
                    </table>
                </td>
            @endfor
        </tr>
    </table>

    <div style="display: block">
        <p style="text-align: justify">
            Nesses termos, solicita-se a adesão do município {{ $adesao->municipio->no_municipio  }} ao Programa
            Município Mais Cidadão.
        </p>
    </div>

    <div>
        <div>
            <p>Local e data:</p>
            <p>{{ $adesao->municipio->no_municipio  }} - {{ $adesao->municipio->uf->sg_uf  }} , ____ de ___________ de
                20__</p>
        </div>
    </div>
    <div>
        <div style="float: right">
            <p style="text-align: center;width: 320px;margin-top: -5px;">_______________________________________</p>
            <p style="text-align: center;width: 320px;margin-top: -5px;">{{ $adesao->no_prefeito  }}</p>
            <p style="text-align: center;width: 320px;margin-top: -5px;">(assinatura e carimbo)</p>
        </div>
    </div>
</main>


</body>
</html>