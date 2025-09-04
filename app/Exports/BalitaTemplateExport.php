<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalitaTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'no_kk',
            'kepala_keluarga',
            'nik',
            'nama',
            'tgl_lahir',
            'jk',
            'kec',
            'desakel',
            'alamat',
            'latitude',
            'longitude',
        ];
    }
}