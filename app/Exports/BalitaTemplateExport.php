<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalitaTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama',
            'JK',
            'Tgl Lahir',
            'Kec',
            'Desa/Kel',
            'ALAMAT',
        ];
    }

    public function array(): array
    {
        return [
            [
                1,
                '7173045405220001',
                'QUIEENYA KATANG',
                'P',
                '14-05-2022',
                'TOMOHON BARAT',
                'WOLOAN SATU',
                'woloan i ling 7',
            ],
            [
                2,
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
        ];
    }
}