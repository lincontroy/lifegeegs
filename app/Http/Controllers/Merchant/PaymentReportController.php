<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;

use App\Models\Payment;
use App\Models\Userplan;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        $id = Auth::user()->id;
        $data = Payment::with('getway', 'user', 'request')->where('user_id', $id);
        if ($request->start_date || $request->end_date) {
            $start_date = $request->start_date . " 00:00:00";
            $end_date = $request->end_date . " 23:59:59";
            if ($request->start_date == '' && $request->end_date == '') {
                $data = $data->latest()->paginate(10);
            } elseif ($request->start_date == '' && $request->end_date != '') {
                $data = $data->where('created_at', '<', $request->end_date)->latest()->paginate(10);
            } elseif ($request->start_date != '' && $request->end_date == '') {
                $data = $data->where('created_at', '>', $request->start_date)->latest()->paginate(10);
            } else {
                $data = $data->whereBetween('created_at', [$start_date, $end_date])->latest()->paginate(10);
            }
            return view('merchant.payment-report.index', compact('data'));

        } elseif ($request->type == 'getway_name') {
            $q = $request->value;
            $data = $data->whereHas('getway', function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })->latest()->paginate(10);
            return view('merchant.payment-report.index', compact('data'));
        } elseif ($request->type == 'trx_id') {
            $q = $request->value;
            $data = $data->where('trx_id', 'LIKE', "%$q%")->latest()->paginate(10);
            return view('merchant.payment-report.index', compact('data'));
        } elseif ($request->type == 'amount') {
            $q = $request->value;
            $data = $data->where('amount', 'LIKE', "%$q%")->latest()->paginate(10);
            return view('merchant.payment-report.index', compact('data'));
        } else {
            $data = $data->latest()->paginate(10);
            return view('merchant.payment-report.index', compact('data'));
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
    public function show($id)
    {
        $data = Payment::with('getway', 'user', 'request','meta')->findOrFail($id);

        return view('merchant.payment-report.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    
}
