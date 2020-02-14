<!DOCTYPE html>
<html lang="pt-br">
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">
</head>
<body>
<main>
    <table style="width: 100%" cellpadding="2" cellspacing="0">
        <tr>
            <td style="width: 100%; font-size: 13px;">
                <table style="width: 100%;" cellpadding="2" cellspacing="3">
                    <tbody>
                    @foreach($inscricoes as $inscricao)
                        <tr style="margin-bottom: 3px !important;">
                            <td style="width: 34%; text-align: left;">{{$inscricao['no_municipio']}}</td>
                            <td style="width: 10%; text-align: left;">{{$inscricao['no_uf']}}</td>
                            <td style="width: 15%; text-align: left;">{{$inscricao['no_regiao']}}</td>
                            <td style="width: 15%; text-align: left;">{{$inscricao['tp_grupo_municipio']}}</td>
                            <td style="width: 20%; text-align: left;">{{$inscricao['nu_populacao']}}</td>
                            <td style="width: 15%; text-align: left;">{{$inscricao['nu_pontuacao_total']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</main>
</body>
</html>