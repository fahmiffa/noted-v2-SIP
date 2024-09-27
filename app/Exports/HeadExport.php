<?php

namespace App\Exports;

use App\Models\Head;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class HeadExport implements FromArray, WithHeadings, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $da = [];
        $head = Head::whereBetween('created_at', $this->data)->get();
        foreach ($head as $key => $val) {

            $vill = $val->region ? 'Ds. ' . $val->region->name : null;
            $dis = $val->region ? 'Kec. ' . $val->region->kecamatan->name : null;

            $header = json_decode($val->header);

            if ($val->tax) {
                $tax = (object) json_decode($val->tax->parameter);
            }

            $da[] = [
                $key + 1,
                $val->reg,
                $header ? $header[2] : null,
                $val->email,
                $header ? $header[3] : null,
                $header ? $header[5] : null,
                $header ? ucwords(str_replace('_', ' ', $header[6])) : null,
                $vill,
                $dis,
                $val->dokumen,
                $val->numbDoc('barp'),
                $val->tax ? $tax->totRetri : 0,
            ];
        }
        return $da;
    }

    public function headings(): array
    {
        return [
            [
                'Nomor',
                'Registrasi',
                'Pemohon',
                'Email Pemohon',
                'Nomor HP Pemohon',
                'Nama Bangunan',
                'Fungsi Bangunan',
                'Lokasi Bangunan',
                '',
                'Status',
                'No. BARP',
                'Retribusi',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Desa',
                'Kecamatan',
                '',
                '',
                '',
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Menggabungkan sel untuk header utama
                $event->sheet->mergeCells('A1:A2'); // Merge "Nomor"
                $event->sheet->mergeCells('B1:B2'); // Merge "Registrasi"
                $event->sheet->mergeCells('C1:C2'); // Merge "Pemohon"
                $event->sheet->mergeCells('D1:D2'); // Merge "Email Pemohon"
                $event->sheet->mergeCells('E1:E2'); // Merge "Nomor HP Pemohon"
                $event->sheet->mergeCells('F1:F2'); // Merge "Nama Bangunan"
                $event->sheet->mergeCells('G1:G2'); // Merge "Fungsi Bangunan"
                
                // Merge untuk Lokasi Bangunan (Desa dan Kecamatan)
                $event->sheet->mergeCells('H1:I1'); // Merge "Lokasi Bangunan" di header utama
                
                $event->sheet->mergeCells('J1:J2'); // Merge "Status"
                $event->sheet->mergeCells('K1:K2'); // Merge "No. BARP"
                $event->sheet->mergeCells('L1:L2'); // Merge "Retribusi"

                // Menetapkan gaya untuk header
                $event->sheet->getStyle('A1:L2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // // Border untuk header
                // $event->sheet->getStyle('A1:L2')->applyFromArray([
                //     'borders' => [
                //         'allBorders' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //         ],
                //     ],
                // ]);
            },
        ];
    }
}
