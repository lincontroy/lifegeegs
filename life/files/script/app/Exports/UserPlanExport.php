<?php

namespace App\Exports;

use App\Models\Userplan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class UserPlanExport implements
    FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents
{
    use Exportable;

    public function collection()
    {
        $data = UserPlan::with('user')->get();
        return $data;
    }

    public function map($data): array
    {
        return [
            $data->user['name'] ?? null,
            $data->user['phone'] ?? null,
            $data->user['email'] ?? null,
            $data->name ?? null,
            $data->captcha == 1 ? 'Active' : 'Deactive',
            $data->menual_req == 1 ? 'Active' : 'Deactive',
            $data->monthly_req ?? null,
            $data->daily_req ?? null,
            $data->storage_limit ?? null,
            $data->mail_activity == 1 ? 'Active' : 'Deactive',
            $data->fraud_check == 1 ? 'Active' : 'Deactive',
            $data->created_at->format('d.m.Y'),
            $data->created_at->diffForHumans(),

        ];
    }

    public function headings(): array
    {
        return [
            "User Name",
            "User Phone",
            "User Email",
            "Name",
            "Captcha",
            "Manual Request",
            "Monthly Request",
            "Daily Request",
            "Storage Limit",
            "Mail Activity",
            "Fraud Check",
            "Created Date",
            "Created Time",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],

                ]);
            },
        ];
    }
}

