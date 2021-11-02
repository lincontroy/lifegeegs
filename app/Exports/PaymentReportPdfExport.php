<?php

namespace App\Exports;

use App\Models\Payment;
use App\Models\Userplan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentReportPdfExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data = Payment::with('user','getway')->get();
        return view('admin.payment-report.pdf', compact('data'));
    }
}
