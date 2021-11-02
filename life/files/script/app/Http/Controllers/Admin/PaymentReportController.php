<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderReportExport;
use App\Exports\OrderReportPdfExport;
use App\Exports\PaymentInvoiceExport;
use App\Exports\PaymentReportExport;
use App\Exports\PaymentReportPdfExport;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class PaymentReportController extends Controller
{
    public function excel(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new PaymentReportExport(), 'payment-report.xlsx');
    }

    public function csv()
    {
        return (new PaymentReportExport)->download('payment-report.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function pdf(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return (new PaymentReportPdfExport)->download('order-report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function invoicePdf($id)
    {
        $data = Payment::with('getway', 'user', 'request')->findOrFail($id);
        $pdf = PDF::loadView('admin.payment-report.invoice-pdf', compact('data'));
        return $pdf->download('payment-invoice-report.pdf');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */

    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('payment-report'), 401);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            $data = Payment::with('getway', 'user');
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->paginate(10);
            }
            return view('admin.payment-report.index', compact('data'));

        } elseif ($request->type == 'customer_name') {
            $q = $request->value;
            $data = Payment::with('getway', 'user')->whereHas('user', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.payment-report.index', compact('data'));
        } elseif ($request->type == 'customer_email') {
            $q = $request->value;
            $data = Payment::with('getway', 'user')->whereHas('user', function ($query) use ($q) {
                return $query->where('email', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.payment-report.index', compact('data'));
        } elseif ($request->type == 'getway_name') {
            $q = $request->value;
            $data = Payment::with('getway', 'user')->whereHas('getway', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->paginate(10);
            return view('admin.payment-report.index', compact('data'));
        } elseif ($request->type == 'trx_id') {
            $q = $request->value;
            $data = Payment::with('getway', 'user')->where('trx_id', 'LIKE', "%$q%")->paginate(10);
            return view('admin.payment-report.index', compact('data'));
        } else {
            $data = Payment::with('getway', 'user')->paginate(10);
            return view('admin.payment-report.index', compact('data'));
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $data = Payment::with('getway', 'user', 'request')->findOrFail($id);
        return view('admin.payment-report.show', compact('data'));
    }


}
