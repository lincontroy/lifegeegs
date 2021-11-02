<?php

namespace App\Http\Controllers\Admin;
use App\Models\Getway;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        abort_if(!Auth()->user()->can('payment-gateway.index'), 401);
        $gateways = Getway::all();
        return view('admin.payment-gateway.index', compact('gateways'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('payment-gateway.create'), 401);
        return view('admin.payment-gateway.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|unique:getways,name',
            'logo'            => 'nullable|mimes:jpeg,png,jpg,svg,gif|max:500',
            'rate'            => 'required',
            'charge'          => 'required',
            'currency_name'   => 'required',
            'instruction'   => 'required',
        ]);

        $gateway = new Getway;

        if ($request->hasFile('logo')) {
            if (!empty($gateway->logo) && file_exists($gateway->logo)) {
                unlink($gateway->logo);
            }
            $logo      = $request->file('logo');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/payment_gateway/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $gateway->logo = $logo_path . $logo_name;
        }

        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->namespace = 'App\Lib\CustomGetway';
        $gateway->currency_name = $request->currency_name;
        $gateway->is_auto = 0;
        $gateway->image_accept = $request->image_accept;
        $gateway->test_mode = $request->test_mode;
        $gateway->image_accept = $request->image_accept;
        $gateway->customer_status = $request->customer_status;
        $gateway->global_status = $request->global_status;
        $gateway->fraud_checker = $request->fraud_checker;
        $data['instruction']=$request->instruction;
        
        $gateway->data=json_encode($data);
        $gateway->save();

        return response()->json('Getway created');
    }




    /**
     * Display the specified resource.
     *
     * @param PaymentGateway $paymentGateway
     * @return Response
     */
    public function show(PaymentGateway $paymentGateway): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('payment-gateway.edit'), 401);
        $gateway = Getway::findOrFail($id);
        return view('admin.payment-gateway.edit', compact('gateway'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'            => 'required|unique:getways,name,' . $id,
            'logo'            => 'nullable|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'rate'            => 'required',
            'charge'          => 'required',
            'namespace'       => 'nullable',
            'currency_name'   => 'required',
        ]);

        $gateway = Getway::findOrFail($id);

        if ($request->hasFile('logo')) {
            if (!empty($gateway->logo) && file_exists($gateway->logo)) {
                unlink($gateway->logo);
            }
            $logo      = $request->file('logo');
            $logo_name = hexdec(uniqid()) . '.' . $logo->getClientOriginalExtension();
            $logo_path = 'uploads/' . date('y/m/');
            $logo->move($logo_path, $logo_name);
            $gateway->logo = $logo_path . $logo_name;
        }

        $gateway->name = $request->name;
        $gateway->rate = $request->rate;
        $gateway->charge = $request->charge;
        $gateway->namespace = $request->namespace ?? 'App\Lib\CustomGetway';
        $gateway->currency_name = $request->currency_name;
        $gateway->is_auto = $request->is_auto;
        $gateway->image_accept = $request->image_accept;
        $gateway->test_mode = $request->test_mode;
        $gateway->image_accept = $request->image_accept;
        $gateway->customer_status = $request->customer_status;
        $gateway->global_status = $request->global_status;
        $gateway->fraud_checker = $request->fraud_checker;
        $gateway->data = $request->data ? json_encode($request->data) : '';
        $gateway->save();

        return response()->json('Successfully Updated!');
    }



  
}
