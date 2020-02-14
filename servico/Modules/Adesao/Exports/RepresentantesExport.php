<?php

namespace Modules\Adesao\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;

/**
 * Class RepresentantesExport
 * @package Modules\Adesao\Exports
 */
class RepresentantesExport extends DefaultValueBinder implements
    FromArray,
    WithCustomCsvSettings,
    WithHeadings,
    WithCustomValueBinder,
    WithStrictNullComparison
{
    use Exportable;

    /**
     * @var array
     */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
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
            'Nome',
            'CPF',
            'UF',
            'Município',
            'Telefone',
            'E-mail'
        ];
    }

    /**
     * @inheritDoc
     */
    public function array(): array
    {
        return $this->data;
    }
}