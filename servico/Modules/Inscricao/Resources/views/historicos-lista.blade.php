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
                    @foreach($historicos as $historico)
                        <tr>
                            <td style="width: 15%; text-align: left;">{{$historico['dh_resposta']}}</td>
                            <td style="width: 10%; text-align: left;">{{$historico['nu_cpf']}}</td>
                            <td style="width: 20%; text-align: left;">{{$historico['no_usuario']}}</td>
                            <td style="width: 10%; text-align: left;">{{$historico['ds_grupo']}}</td>
                            <td style="width: 25%; text-align: left;">{{$historico['ds_item']}}</td>
                            <td style="width: 10%; text-align: left;">{{$historico['st_resposta_antiga']}}</td>
                            <td style="width: 10%; text-align: left;">{{$historico['st_resposta_atual']}}</td>
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