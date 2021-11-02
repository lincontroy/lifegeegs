<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Currencygetway;
use App\Models\Getway;
use App\Models\Usergetway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $gateway_auto = Getway::with('usergetwaycreds')->where([['is_auto',1],['customer_status',1],['global_status',1]])->get();
         $gateway_manual = Getway::with('usergetwaycreds')->where([['is_auto',0],['customer_status',1],['global_status',1]])->get();

        return view('merchant.gateway.index', compact('gateway_auto','gateway_manual'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate
        $request->validate([
            'name' => 'required',
            'gateway_id' => 'required',
            'currency_name' => 'required',
            'phone_required' => 'required',
            'rate' => 'required',
            'charge' => 'required',
        ]);


        $getway = Getway::findOrFail($request->gateway_id);
        $user_gateway = Usergetway::where('user_id',Auth::id())->where('getway_id', $request->gateway_id)->firstOrNew();
        if($getway->is_auto == 1){
            $request->validate([
                'sandbox' => 'required',
                'production' => 'required',
            ]);
        }

        if($getway->is_auto == 0){
            $request->validate([
                'instruction' => 'required',
            ]);
            $user_gateway->data = json_encode(['instruction'=>$request->instruction]);
        }

        
        $user_gateway->name = $request->name;
        $user_gateway->getway_id = $request->gateway_id;
        $user_gateway->user_id = Auth::id();
        $user_gateway->phone_required = $request->phone_required;
        $user_gateway->currency_name = strtoupper($request->currency_name);
        $user_gateway->rate = $request->rate;
        $user_gateway->charge= $request->charge;
        $user_gateway->status = $request->status ?? 0;
        $user_gateway->sandbox = json_encode($request->sandbox);
        $user_gateway->sandbox = json_encode($request->sandbox);
        $user_gateway->production = json_encode($request->production);
        $user_gateway->save();


        return response()->json('Installed Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gateway = Getway::with('usergetwaycreds')->findOrFail($id);
        $currencies = Currency::where('status', 1)->get();
        return view('merchant.gateway.edit',compact('gateway','currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   
}
