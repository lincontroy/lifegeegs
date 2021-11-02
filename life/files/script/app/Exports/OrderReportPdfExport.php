<?php

namespace App\Exports;


use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class OrderReportPdfExport implements FromView
{
    use Exportable;
    public function view(): View
    {
        $data = Order::with('plan', 'getway', 'user')->get();
        return view('admin.report.pdf', compact('data'));
    }
}
