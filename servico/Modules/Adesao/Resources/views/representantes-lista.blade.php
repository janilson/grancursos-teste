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
                    @foreach($representantes as $representantes)
                        <tr style="margin-bottom: 3px !important;">
                            <td style="width: 20%; text-align: left;">{{$representantes['no_servidor']}}</td>
                            <td style="width: 15%; text-align: left;">{{$representantes['nu_cpf']}}</td>
                            <td style="width: 5%; text-align: left;">{{$representantes['sg_uf']}}</td>
                            <td style="width: 25%; text-align: left;">{{$representantes['no_municipio']}}</td>
                            <td style="width: 15%; text-align: left;">{{$representantes['nu_telefone']}}</td>
                            <td style="width: 20%; text-align: left;">{{$representantes['ds_email']}}</td>
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