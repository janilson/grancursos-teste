<?php

namespace Modules\Inscricao\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\DefaultValueBinder;

/**
 * Class HistoricosExport
 * @package Modules\Inscricao\Exports
 */
class HistoricosExport extends DefaultValueBinder implements
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
            'Data',
            'CPF',
            'Nome',
            'Grupo',
            'Item',
            'Anterior',
            'Alteração',
        ];
    }
}