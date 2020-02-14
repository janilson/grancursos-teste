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
                    @foreach($adesoes as $adesao)
                        <tr>
                            <td style="width: 40%; text-align: left;">{{$adesao['no_municipio']}}</td>
                            <td style="width: 15%; text-align: left;">{{$adesao['no_uf']}}</td>
                            <td style="width: 15%; text-align: left;">{{$adesao['no_regiao']}}</td>
                            <td style="width: 15%; text-align: left;">{{$adesao['tp_grupo_municipio']}}</td>
                            <td style="width: 15%; text-align: left;">{{$adesao['nu_populacao']}}</td>
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