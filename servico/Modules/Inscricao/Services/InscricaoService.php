<?php

namespace Modules\Inscricao\Services;

use App\Exceptions\BadRequestException;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Entities\Servidor;
use Modules\Autenticacao\Entities\Usuario;
use Modules\Autenticacao\Repository\UsuarioRepositoryInterface;
use Modules\Inscricao\Emails\InscricaoEmail;
use Modules\Inscricao\Entities\Arquivo;
use Modules\Inscricao\Entities\BloqueioInscricao;
use Modules\Inscricao\Entities\Grupo;
use Modules\Inscricao\Entities\InscricaoEnvio;
use Modules\Inscricao\Entities\Item;
use Modules\Inscricao\Entities\Resposta;
use Modules\Inscricao\Entities\RespostaHistorico;
use Modules\Inscricao\Exceptions\AdesaoJaPossuiInscricaoException;
use Modules\Inscricao\Exceptions\ErroAoSalvarInscricaoEnvioException;
use Modules\Inscricao\Exceptions\ErroAoSalvarRespostasException;
use Modules\Inscricao\Exceptions\ErroAoSalvarRespostasGrupoInvalidoException;
use Modules\Inscricao\Filters\RespostaHistoricoFilter;

/**
 * Class InscricaoService
 * @package Modules\Inscricao\Services
 */
class InscricaoService
{
    /**
     * @var UsuarioRepositoryInterface
     */
    private $usuarioRepository;

    /**
     * InscricaoService constructor.
     * @param UsuarioRepositoryInterface $usuarioRepository
     */
    public function __construct(UsuarioRepositoryInterface $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    /**
     * @param Adesao $adesao
     * @param Grupo $grupo
     * @param array $respostas
     * @param Usuario $usuario
     * @param \DateTime $data
     * @param UploadedFile|null $file
     * @return array
     * @throws \Exception
     */
    public function atualizarItensPorGrupo(Adesao $adesao, Grupo $grupo, array $respostas,
                                           Usuario $usuario, \DateTime $date, UploadedFile $file = null)
    {
        $nomeGrupo = in_array($grupo->co_grupo, [0, 9]) ? $grupo->ds_grupo : "Grupo {$grupo->co_grupo} - {$grupo->ds_grupo}";
        $data = $date->format('Y-m-d H:i:s');

        $namePath = null;

        try {
            DB::beginTransaction();

            if ($adesao->existeBloqueio($usuario)) {
                throw new BadRequestException('Inscrição esta bloqueada por ' . $adesao->bloqueioAtivo()->usuario->no_usuario . '!');
            }

            foreach ($respostas as $k => $resposta) {
                $resposta = (array)$resposta;
                $respostaAntiga = Resposta::find($resposta[Resposta::CO_FORMULARIO_RESPOSTA]);

                if ($respostaAntiga) {
                    $item = $respostaAntiga->item;

                    if ($item->grupo->co_grupo != $grupo->co_grupo) {
                        throw new ErroAoSalvarRespostasGrupoInvalidoException($nomeGrupo);
                    }

                    Resposta::where([
                        Resposta::CO_FORMULARIO_RESPOSTA => $resposta[Resposta::CO_FORMULARIO_RESPOSTA],
                        Adesao::CO_ADESAO => $adesao->co_adesao
                    ])->update([Resposta::ST_RESPOSTA => $resposta[Resposta::ST_RESPOSTA]]);

                    /* Caso não seja pré-requisitos*/
                    if ($resposta[Resposta::ST_RESPOSTA] != $respostaAntiga->st_resposta && 0 !== $grupo->co_grupo) {
                        $insert =
                            [
                                'co_formulario_resposta' => $resposta['co_formulario_resposta'],
                                'co_usuario' => $usuario->co_usuario,
                                'st_resposta_antiga' => $respostaAntiga->st_resposta,
                                'st_resposta_atual' => $resposta['st_resposta'],
                                'dh_resposta' => $data,
                            ];

                        if (!$this->adicionarRespostaHistorico($insert)) {
                            throw new ErroAoSalvarRespostasException($nomeGrupo);
                        }
                    }
                }
            }

            $updateAdesao = ['st_envio' => 'P'];
            $arquivoAntigo = null;
            $hasArquivoAntigo = false;

            if (0 === $grupo->co_grupo && !is_null($file) && $file->isValid()) {
                $arquivo = new Arquivo();

                if (!is_null($adesao->co_arquivo)) {
                    $arquivoAntigo = $adesao->arquivo->ds_caminho_arquivo;
                    $arquivo = $adesao->arquivo;
                    $hasArquivoAntigo = file_exists($arquivoAntigo);
                }

                $no_municipio = $this->tirarAcentosEspacos($adesao->municipio->no_municipio
                    . "-" . $adesao->municipio->uf->sg_uf);

                $nameFile = "Pre-Requisitos-{$no_municipio}-"
                    . "{$date->format('Y-m-d-H-i-s')}.{$file->getClientOriginalExtension()}";

                $namePath = storage_path('inscricao') . DIRECTORY_SEPARATOR . $nameFile;

                if (!$file->storeAs('', $nameFile, 'inscricao')) {
                    throw new BadRequestException('Falha ao fazer upload!');
                }

                $no_arquivo = $this->tirarAcentosEspacos(
                        \Str::replaceLast(".{$file->getClientOriginalExtension()}",
                            "",
                            $file->getClientOriginalName()))
                    . ".{$file->getClientOriginalExtension()}";

                $arquivo->no_arquivo = $no_arquivo;
                $arquivo->ds_caminho_arquivo = $namePath;
                $arquivo->no_extensao = $file->extension();
                $arquivo->no_mime_type = $file->getMimeType();
                $arquivo->dh_arquivo = $data;

                if (!$arquivo->save()) {
                    throw new BadRequestException('Falha ao fazer upload!');
                }

                $updateAdesao['co_arquivo'] = $arquivo->co_arquivo;
                $updateAdesao['co_usuario_arquivo'] = $usuario->co_usuario;
            }

            Adesao::where([Adesao::CO_ADESAO => $adesao->co_adesao])
                ->update($updateAdesao);

            BloqueioInscricao::updateOrCreate(
                [
                    'st_bloqueio' => 'B',
                    'co_adesao' => $adesao->co_adesao,
                    'co_usuario' => $usuario->co_usuario
                ],
                [
                    'st_bloqueio' => 'B',
                    'co_adesao' => $adesao->co_adesao,
                    'co_usuario' => $usuario->co_usuario,
                    'dh_bloqueio' => $data
                ]
            );

            if (0 === $grupo->co_grupo && $hasArquivoAntigo) {
                unlink($arquivoAntigo);
            }

            DB::commit();

            return [
                'code' => 202,
                'message' => "{$nomeGrupo} atualizado com sucesso!"
            ];
        } catch (\Exception $exception) {
            DB::rollBack();

            if (file_exists($namePath)) {
                unlink($namePath);
            }

            throw $exception;
        }
    }

    /**
     * @param Adesao $adesao
     * @param Grupo $grupo
     * @param array $respostas
     * @param Usuario $usuario
     * @param \DateTime $date
     * @param UploadedFile|null $file
     * @return array
     * @throws \Exception
     */
    public function salvarPreRequisitos(Adesao $adesao, Grupo $grupo, array $respostas,
                                        Usuario $usuario, \DateTime $date, UploadedFile $file = null)
    {
        if (0 !== $grupo->co_grupo) {
            throw new BadRequestException('Não são Pré Requisitos válidos para Adesão.');
        }

        $itensResp = $grupo->itens()
            ->where('tp_formulario_item_inscricao', '=', 'R')
            ->get()
            ->count();

        if (count($respostas) != $itensResp) {
            throw new BadRequestException('Respostas inválidas!');
        }

        if ((is_null($adesao->co_arquivo) && is_null($file))) {
            throw new BadRequestException('Arquivo inválido!');
        }

        return $this->atualizarItensPorGrupo($adesao, $grupo, $respostas, $usuario, $date, $file);
    }

    /**
     * @param $insert
     * @return bool
     */
    public function adicionarRespostaHistorico($insert): bool
    {
        return DB::table('th_resposta')->insert($insert);
    }

    /**
     * @param Adesao $adesao
     * @return mixed
     */
    public function obterRespostasHistoricos(Adesao $adesao)
    {
        $historicos = RespostaHistorico::filtered(\App::make(RespostaHistoricoFilter::class))
            ->where('co_adesao', $adesao->co_adesao);

        return $historicos;
    }

    /**
     * @param Adesao $adesao
     * @param \DateTime $data
     * @param Usuario $usuario
     * @return Adesao
     * @throws \Exception
     */
    public function iniciarInscricao(Adesao $adesao, \DateTime $data, Usuario $usuario): Adesao
    {
        $this->adesaoSemInscricao($adesao);

        try {
            DB::beginTransaction();

            Item::where('tp_formulario_item_inscricao', '=', 'R')
                ->get()
                ->each(function (Item $item) use ($adesao, $data, $usuario) {
                    Resposta::create([
                        'co_formulario_item_inscricao' => $item->co_formulario_item_inscricao,
                        'co_adesao' => $adesao->co_adesao,
                        'co_usuario_cadastro' => $usuario->co_usuario,
                        'dh_resposta' => $data->format('Y-m-d H:i:s')
                    ]);
                });

            Adesao::where([Adesao::CO_ADESAO => $adesao->co_adesao])
                ->update(['st_envio' => 'A']);

            BloqueioInscricao::create([
                'st_bloqueio' => 'B',
                'co_adesao' => $adesao->co_adesao,
                'co_usuario' => $usuario->co_usuario,
                'dh_bloqueio' => $data->format('Y-m-d H:i:s')
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $adesao;
    }

    /**
     * @param Adesao $adesao
     * @return bool
     */
    public function adesaoSemInscricao(Adesao $adesao): bool
    {
        /** @var \Illuminate\Support\Collection $resposta */
        $resposta = Resposta::where('co_adesao', $adesao->co_adesao)->get();

        if ($resposta->isNotEmpty()) {
            throw new AdesaoJaPossuiInscricaoException();
        }

        return true;
    }

    public function gerarPdf(Adesao $adesao, \DateTime $date)
    {
        $grupos = Grupo::all();

        return \PDF::loadView('inscricao::inscricao',
            [
                'grupos' => $grupos,
                'adesao' => $adesao,
                'pontuacaoTotal' => $adesao->pontuacaoTotal(),
                'data' => $date->format('d/m/Y')
            ])
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'header-html' => \View::make('inscricao::inscricao-header-maiscidadao')->render(),
                'footer-html' => \View::make('inscricao::footer-maiscidadao')->render(),
            ]);
    }

    /**
     * @param Adesao $adesao
     * @param \DateTime $data
     * @return string
     */
    public function salvarPdfInscricao(Adesao $adesao, \DateTime $date): string
    {
        $no_municipio = $this->tirarAcentosEspacos($adesao->municipio->no_municipio . "-" . $adesao->municipio->uf->sg_uf);
        $inscricaoNome = storage_path('inscricao') . DIRECTORY_SEPARATOR
            . "Inscricao-{$no_municipio}-{$date->format('Y-m-d-H-i-s')}.pdf";

        $this->gerarPdf($adesao, $date)->save($inscricaoNome);

        return $inscricaoNome;
    }

    /**
     * @param Adesao $adesao
     * @param \DateTime $date
     * @param Usuario $usuario
     * @return array
     * @throws \Exception
     */
    public function enviarInscricao(Adesao $adesao, \DateTime $date, Usuario $usuario): array
    {
        $noMunicipio = $adesao->municipio->no_municipio;

        try {
            DB::beginTransaction();

            if ($adesao->existeBloqueio($usuario)) {
                throw new BadRequestException('Inscrição esta bloqueada por ' . $adesao->bloqueioAtivo()->usuario->no_usuario);
            }

            $ds_caminho_arquivo = $this->salvarPdfInscricao($adesao, $date);

            $hasEnvio = $adesao->inscricaoEnvios()->count() > 0;

            $create = InscricaoEnvio::create([
                'co_adesao' => $adesao->co_adesao,
                'co_usuario_envio' => $usuario->co_usuario,
                'ds_envio' => $adesao->respostas->toJson(),
                'ds_caminho_arquivo' => $ds_caminho_arquivo,
                'dh_envio' => $date->format('Y-m-d H:i:s'),
                'nu_pontuacao_atual' => $adesao->pontuacaoTotal()
            ]);

            if (!$create) {
                throw new ErroAoSalvarInscricaoEnvioException($noMunicipio);
            }

            Adesao::where([Adesao::CO_ADESAO => $adesao->co_adesao])
                ->update(['st_envio' => 'E']);

            BloqueioInscricao::where(['co_bloqueio_inscricao' => $adesao->bloqueioAtivo()->co_bloqueio_inscricao])
                ->update(['st_bloqueio' => 'D']);

            DB::commit();

            $errorEmail = false;
            $adesao->servidores
                ->each(function (Servidor $servidor) use ($adesao, $ds_caminho_arquivo, $hasEnvio, $usuario, $date, &$errorEmail) {
                    try {
                        \Mail::send(new InscricaoEmail($adesao, $servidor, $ds_caminho_arquivo, $hasEnvio, $usuario, $date));
                    } catch (\Exception $exception) {
                        $errorEmail = true;
                        return;
                    }
                });

            if ($errorEmail) {
                return [
                    'code' => 202,
                    'message' => "Inscrição do município {$noMunicipio} salva com sucesso, mas houve erro ao enviar o(s) email(s)!"
                ];
            }

            return [
                'code' => 202,
                'message' => "Inscrição do município {$noMunicipio} enviada com sucesso!"
            ];
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param $string
     * @param string $slug
     * @return string
     */
    public function tirarAcentosEspacos($string, $slug = "-")
    {
        return \Str::ascii(\Str::slug($string, $slug));
    }
}