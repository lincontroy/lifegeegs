<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class PaymentReportExport implements FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents
{
    use Exportable;

    public function collection()
    {
        $data = Payment::with('getway','user')->get();
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->getway['name'] ?? null,
            $data->user['name'] ?? null,
            $data->user['phone'] ?? null,
            $data->user['email'] ?? null,
            $data->amount ?? null,
            $data->trx_id ?? null,
            $data->status==1 ? 'Active':'Deactive',
            $data->created_at->format('d.m.Y'),
            $data->created_at->diffForHumans(),

        ];
    }
    public function headings(): array
    {
        return [
            "Gateway Name",
            "User Name",
            "User Phone",
            "User Email",
            "Amount",
            "Trx Id",
            "Status",
            "Created Date",
            "Created Time",
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font'      => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders'   => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill'      => [
                        'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation'   => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor'   => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],

                ]);
            },
        ];
    }
}

