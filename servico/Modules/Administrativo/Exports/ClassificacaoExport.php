<?php

namespace Modules\Administrativo\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;

/**
 * Class ClassificacaoExport
 * @package Modules\Administrativo\Exports
 */
class ClassificacaoExport extends DefaultValueBinder implements
    FromCollection,
    WithCustomCsvSettings,
    WithHeadings,
    WithCustomValueBinder,
    WithStrictNullComparison
{
    use Exportable;
    /**
     * @var Collection
     */
    private $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function collection()
    {
        return $this->data;
    }

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
            'Municipio',
            'UF',
            'Grupo Municipal',
            'Pontuação',
            'Classificação',
        ];
    }
}