<?php


namespace Modules\Adesao\Imports;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Adesao\Emails\ComunicadoMail;

class ServidoresImport implements ToCollection, WithHeadingRow
{
    use Importable;
    /**
     * @inheritDoc
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
           Mail::send(new ComunicadoMail($row['ds_email']));
        }
    }

}