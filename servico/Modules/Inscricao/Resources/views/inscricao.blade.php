<!DOCTYPE html>
<html lang="pt-br">
<head xmlns="http://www.w3.org/1999/html">
    <meta charset="UTF-8">
    <style>
        html {
            font-size: 20px !important;
            letter-spacing: 2;
        }
    </style>
</head>
<body>
<main>
    <div style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">
        Formulário de inscrição do município {{$adesao->municipio->no_municipio}} - {{$adesao->municipio->uf->sg_uf}},
        enviado em {{ $data }}
    </div>
    <div style="width: 100%;">
        <div style="float:right;color: #ff3d00; font-weight: bold">
            Soma Total de Pontos {{$pontuacaoTotal}}
        </div>
    </div>

    <div style="margin-bottom: 10px;">
        @foreach ($grupos as $grupo)
            <div style="padding-left: 1.5em; font-weight: bold;margin-bottom: 8px;">
                @if(!in_array($grupo->co_grupo, [0, 9]))
                    Grupo {{ $grupo->co_grupo }} - {{ $grupo->ds_grupo }} (pontuação
                    máxima: {{ $grupo->nu_pontuacao_total }})
                @else
                    {{ $grupo->ds_grupo }}
                @endif
            </div>
            @foreach ($grupo->itensSemPai() as $item)
                @if (strtolower($item->tp_formulario_item_inscricao) == 'p')
                    <div style="padding-left: 1.5em;">{{ $item->ds_formulario_item_inscricao }} </div>
                    @foreach ($item->filhas as $filhas)
                        {{ $filhas->respostaAdesao($adesao->co_adesao) }}
                        <div style="padding-left: 1.5em;; vertical-align: middle">
                            <input type="checkbox"
                                   {{ $filhas->st_resposta ? 'checked' : ''  }} style="vertical-align: middle">
                            {{ $filhas->ds_formulario_item_inscricao }}
                        </div>
                    @endforeach
                @else
                    <div style="padding-left: 1.5em;; vertical-align: middle">
                        {{ $item->respostaAdesao($adesao->co_adesao) }}
                        <input type="checkbox"
                               {{ $item->st_resposta ? 'checked' : ''  }} style="vertical-align: middle">
                        {{ $item->ds_formulario_item_inscricao }}
                    </div>
                @endif
            @endforeach
            <hr/>
        @endforeach
    </div>
</main>
</body>
</html>