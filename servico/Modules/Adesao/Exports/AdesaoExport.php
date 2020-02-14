<?php

namespace Modules\Adesao\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;
use Modules\Adesao\Entities\Adesao;
use Modules\Adesao\Filters\AdesaoFilter;

/**
 * Class AdesaoExport
 * @package Modules\Adesao\Exports
 */
class AdesaoExport extends DefaultValueBinder implements
    FromQuery,
    WithCustomCsvSettings,
    WithHeadings,
    WithCustomValueBinder,
    WithStrictNullComparison,
    WithMapping
{
    use Exportable;


    /**
     * @inheritDoc
     */
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';'
        ];
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Município',
            'UF',
            'Região',
            'Grupo Municipal',
            'População'
        ];
    }


    /**
     * @inheritDoc
     */
    public function query()
    {
        return Adesao::filtered(app(AdesaoFilter::class));
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        $array = [
            1 => 'Grupo I',
            2 => 'Grupo II',
            3 => 'Grupo III',
            4 => 'Grupo IV',
            5 => 'Grupo V',
        ];

        $fn = function ($tipo) use ($array) {
            return $array[$tipo];
        };

        return [
            $row->no_municipio,
            $row->sg_uf,
            $row->no_regiao,
            $fn($row->tp_grupo_municipio),
            $row->nu_populacao
        ];
    }
}