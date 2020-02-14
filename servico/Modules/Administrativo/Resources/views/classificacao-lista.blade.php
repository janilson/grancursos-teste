<!DOCTYPE html>
<html lang="pt-br">
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">
</head>
<body>
<main>
    <table style="width: 100%" cellpadding="2" cellspacing="0">
        <tr>
            <td>
                <table style="width: 100%; font-size: 13px;" cellpadding="2" cellspacing="3">
                    <tbody>
                    @foreach($classificacoes as $classificacao)
                        <tr>
                            <td style="width: 35%; text-align: left;">{{$classificacao['no_municipio']}}</td>
                            <td style="width: 15%; text-align: left;">{{$classificacao['sg_uf']}}</td>
                            <td style="width: 15%; text-align: left;">{{$classificacao['ds_grupo_municipio']}}</td>
                            <td style="width: 20%; text-align: left;">{{$classificacao['nu_pontuacao_total']}}</td>
                            <td style="width: 15%; text-align: left;">{{$classificacao['nu_classificacao']}}</td>
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