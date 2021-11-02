<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderReportExport implements
    FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents
{
    use Exportable;

    public function collection()
    {
        $data = Order::with('plan','getway','user')->get();
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->plan['name'] ?? null,
            $data->plan['duration'] ?? null,
            $data->getway['name'] ?? null,
            $data->user['name'] ?? null,
            $data->user['phone'] ?? null,
            $data->user['email'] ?? null,
            $data->amount ?? null,
            $data->exp_date ?? null,
            $data->payment_status==1 ? 'Done':'pending',
            $data->payment_id ?? null,
            $data->status==1 ? 'Active':'Deactive',
            $data->created_at->format('d.m.Y'),
            $data->created_at->diffForHumans(),

        ];
    }
    public function headings(): array
    {
        return [
            "Plan Name",
            "Plan duration",
            "Gateway Name",
            "User Name",
            "User Phone",
            "User Email",
            "Amount",
            "Exp Date",
            "Payment Status",
            "Payment ID",
            "Status",
            "Created Date",
            "Created Time",
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:M1')->applyFromArray([
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
