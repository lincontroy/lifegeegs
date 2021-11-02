<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserPlanExport;
use App\Exports\UserPlanPdfExport;
use App\Http\Controllers\Controller;
use App\Models\Userplan;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class UserPlanReportController extends Controller
{
    public function excel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new UserPlanExport(), 'user-plan-report.xlsx');
    }

    public function csv()
    {
        return (new UserPlanExport)->download('user-plan-report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function pdf(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return (new UserPlanPdfExport)->download('user-plan-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function invoicePdf($id)
    {
        $data = Userplan::with('user')->findOrFail($id);
        $pdf = PDF::loadView('admin.user-plan-report.invoice-pdf', compact('data'));
        return $pdf->download('user-plan-invoice.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function userPlan(Request $request)
    {
        abort_if(!Auth()->user()->can('user-plan-report'), 401);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            $data = Userplan::with('user');
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }
            return view('admin.user-plan-report.user-plan', compact('data'));

        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisWeek') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisMonth') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisYear') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            }
        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisWeek') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisMonth') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            } elseif ($request->select_day == 'thisYear') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.user-plan', compact('data'));
            }
        } elseif ($request->type == 'customer_name') {
            $q = $request->value;
            $data = Userplan::with('user')->whereHas('user', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.user-plan-report.user-plan', compact('data'));
        } elseif ($request->type == 'customer_email') {
            $q = $request->value;
            $data = Userplan::with('user')->whereHas('user', function ($query) use ($q) {
                return $query->where('email', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.user-plan-report.user-plan', compact('data'));
        } elseif ($request->type == 'plan_name') {
            $q = $request->value;
            $data = Userplan::with('user')->where('name', 'LIKE', "%$q%")->paginate(10);
            return view('admin.user-plan-report.user-plan', compact('data'));
        } elseif ($request->type == 'storage_limit') {
            $q = $request->value;
            $data = Userplan::with('user')->where('storage_limit', 'LIKE', "%$q%")->paginate(10);
            return view('admin.user-plan-report.user-plan', compact('data'));
        } else {
            $data = Userplan::with('user')->paginate(10);
            return view('admin.user-plan-report.user-plan', compact('data'));
        }
    }
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('user-plan-report'), 401);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            $data = Userplan::with('user');
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }
            return view('admin.user-plan-report.index', compact('data'));

        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisWeek') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisMonth') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisYear') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            }
        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisWeek') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisMonth') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            } elseif ($request->select_day == 'thisYear') {
                $data = Userplan::with('user')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.user-plan-report.index', compact('data'));
            }
        } elseif ($request->type == 'customer_name') {
            $q = $request->value;
            $data = Userplan::with('user')->whereHas('user', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.user-plan-report.index', compact('data'));
        } elseif ($request->type == 'customer_email') {
            $q = $request->value;
            $data = Userplan::with('user')->whereHas('user', function ($query) use ($q) {
                return $query->where('email', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.user-plan-report.index', compact('data'));
        } elseif ($request->type == 'plan_name') {
            $q = $request->value;
            $data = Userplan::with('user')->where('name', 'LIKE', "%$q%")->paginate(10);
            return view('admin.user-plan-report.index', compact('data'));
        } elseif ($request->type == 'storage_limit') {
            $q = $request->value;
            $data = Userplan::with('user')->where('storage_limit', 'LIKE', "%$q%")->paginate(10);
            return view('admin.user-plan-report.index', compact('data'));
        } else {
            $data = Userplan::with('user')->paginate(10);
            return view('admin.user-plan-report.index', compact('data'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $data = Userplan::with('user')->findOrFail($id);
        return view('admin.user-plan-report.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Userplan::with('user')->findOrFail($id);
        return view('admin.user-plan-report.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'monthly_req'   => 'required',
            'daily_req'     => 'required',
            'storage_limit' => 'required',
        ]);
        $obj = Userplan::findOrFail($id);
        $obj->fill($request->all())->save();
        return response()->json('User Plan Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
