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

            $vill = $val->region ? $val->region->name : null;
            $dis = $val->region ? $val->region->kecamatan->name : null;

            $header  = json_decode($val->header);
            $mheader = $val->barp ? json_decode($val->barp->header) : null;

            if ($val->tax) {
                $tax = (object) json_decode($val->tax->parameter);
            }

            $da[] = [
                $key + 1,
                $val->reg,
                $header ? $header[2] : null,
                $header ? $header[4] : null,
                $val->email,
                $header ? $header[3] : null,
                $header ? $header[5] : null,
                $header ? ucwords(str_replace('_', ' ', $header[6])) : null,
                $header && isset($header[8]) ? $header[8] : null,
                $header ? $header[7] : null,
                $vill,
                $dis,
                $header && isset($header[9] ) ? $header[9] : null,
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
                'Alamat Pemohon',
                'Email Pemohon',
                'Nomor HP Pemohon',
                'Nama Bangunan',
                'Fungsi Bangunan', 
                'Koordinat', 
                'Lokasi Bangunan',       
                '',
                '',         
                'No. Dokumen Tanah',
                'Status',
                'No. BARP',
                'Retribusi'
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',           
                '',                
                '',                            
                'Alamat',
                'Desa',
                'Kecamatan',
                '',
                '',
                '',
                ''                
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
               
                $event->sheet->mergeCells('A1:A2'); 
                $event->sheet->mergeCells('B1:B2'); 
                $event->sheet->mergeCells('C1:C2'); 
                $event->sheet->mergeCells('D1:D2'); 
                $event->sheet->mergeCells('E1:E2'); 
                $event->sheet->mergeCells('F1:F2'); 
                $event->sheet->mergeCells('G1:G2'); 
                $event->sheet->mergeCells('H1:H2'); 
                $event->sheet->mergeCells('I1:I2'); 

                $event->sheet->mergeCells('J1:L1');                 
          
                $event->sheet->mergeCells('M1:M2');
                $event->sheet->mergeCells('N1:N2'); 
                $event->sheet->mergeCells('O1:O2'); 
                $event->sheet->mergeCells('P1:P2'); 

                // Menetapkan gaya untuk header
                $event->sheet->getStyle('A1:P2')->applyFromArray([
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
