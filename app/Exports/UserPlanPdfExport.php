<?php

namespace App\Exports;

use App\Models\Userplan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UserPlanPdfExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $data = Userplan::with('user')->get();
        return view('admin.user-plan-report.pdf', compact('data'));
    }
}
