<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderReportExport;
use App\Exports\OrderReportPdfExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class ReportController extends Controller
{
    public function excel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new OrderReportExport(), 'order-report.xlsx');
    }

    public function csv()
    {
        return (new OrderReportExport)->download('order-report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function pdf(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return (new OrderReportPdfExport)->download('order-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function invoicePdf($id)
    {
        $data = Order::with('plan', 'getway', 'user')->findOrFail($id);
        $pdf = PDF::loadView('admin.report.invoice-pdf', compact('data'));
        return $pdf->download('order-invoice.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('report'), 401);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            $data = Order::with('plan', 'getway', 'user');
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }
            return view('admin.report.index', compact('data'));
        } elseif ($request->select_day) {
            if ($request->select_day == 'today') {
                $data = Order::with('plan', 'getway', 'user')->whereBetween('created_at', [Carbon::now()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.report.index', compact('data'));
            } elseif ($request->select_day == 'thisWeek') {
                $data = Order::with('plan', 'getway', 'user')->whereBetween('created_at', [Carbon::now()->startOfWeek()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfWeek()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.report.index', compact('data'));
            } elseif ($request->select_day == 'thisMonth') {
                $data = Order::with('plan', 'getway', 'user')->whereBetween('created_at', [Carbon::now()->firstOfMonth()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfMonth()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.report.index', compact('data'));
            } elseif ($request->select_day == 'thisYear') {
                $data = Order::with('plan', 'getway', 'user')->whereBetween('created_at', [Carbon::now()->startOfYear()->setTime(0, 0)->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->setTime(23, 59, 59)->format('Y-m-d H:i:s')])->paginate(10);
                return view('admin.report.index', compact('data'));
            }
        } elseif ($request->type == 'customer_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user')->whereHas('user', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.report.index', compact('data'));
        } elseif ($request->type == 'plan_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user')->whereHas('plan', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.report.index', compact('data'));
        } elseif ($request->type == 'getway_name') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user')->whereHas('getway', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.report.index', compact('data'));
        } elseif ($request->type == 'exp_date') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user')->where('exp_date', 'LIKE', "%$q%")->paginate(10);
            return view('admin.report.index', compact('data'));
        } elseif ($request->type == 'payment_id') {
            $q = $request->value;
            $data = Order::with('plan', 'getway', 'user')->where('payment_id', 'LIKE', "%$q%")->paginate(10);
            return view('admin.report.index', compact('data'));
        } else {
            $data = Order::with('plan', 'getway', 'user')->paginate(10);
            return view('admin.report.index', compact('data'));
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
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show(int $id)
    {
        $data = Order::with('plan', 'getway', 'user')->findOrFail($id);
        return view('admin.report.show', compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('report'), 401);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('report'), 401);
    }
}
