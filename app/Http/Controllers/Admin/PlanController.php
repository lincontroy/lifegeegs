<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Order;
use App\Models\Plan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('plan.index'), 401);
        $all = Plan::count();
        $active = Plan::where('status', '1')->count();
        $inactive = Plan::where('status', '0')->count();
        if ($request->has('1') || $request->has('0')) {
            if ($request->has('1')) {
                $data = Plan::withCount('orders')->withCount('acitveorders')->withSum('orders','amount')->where('status', '1')->paginate(10);
            } else {
                $data = Plan::withCount('orders')->withCount('acitveorders')->withSum('orders','amount')->where('status', '0')->paginate(10);
            }
        } else {
            $data = Plan::withCount('orders')->withCount('acitveorders')->withSum('orders','amount')->paginate(10);
        }
        return view('admin.plan.index', compact('data', 'active', 'inactive','all'));
    }


    public function invoicePdf($id)
    {
        $data = Order::with('plan', 'getway', 'user')->findOrFail($id);
        $pdf = PDF::loadView('merchant.plan.invoice-pdf', compact('data'));
        return $pdf->download('order-invoice.pdf');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('plan.create'), 401);
        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PlanRequest $request
     * @return JsonResponse
     */
    public function store(PlanRequest $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'captcha' => 'required',
            'menual_req' => 'required',
            'monthly_req' => 'required',
            'daily_req' => 'required',
            'is_auto' => 'required',
            'is_trial' => 'required',
            'mail_activity' => 'required',
            'storage_limit' => 'required|numeric',
            'fraud_check' => 'required',
            'is_featured' => 'required',
            'is_default' => 'required',
            'status' => 'required',
        ]);
        
        $data = $request->all();
        $obj = new Plan();
        $success = $obj->fill($data)->save();
        if($success){
            return response()->json('Plan Add Successfully');
        }else{
            return response()->json('System Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Plan $plan
     * @return Response
     */
    public function show($id)
    {
        $orders = Order::with('plan', 'getway', 'user')->where('plan_id',$id)->latest()->paginate(20);
        return view('admin.plan.show',compact('orders'));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('plan.edit'), 401);
        $data = Plan::findOrFail($id);
        return view('admin.plan.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PlanRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(PlanRequest $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
            'captcha' => 'required',
            'menual_req' => 'required',
            'monthly_req' => 'required',
            'daily_req' => 'required',
            'is_auto' => 'required',
            'is_trial' => 'required',
            'mail_activity' => 'required',
            'storage_limit' => 'required|numeric',
            'fraud_check' => 'required',
            'is_featured' => 'required',
            'is_default' => 'required',
            'status' => 'required',
        ]);

        $data = $request->all();
        $obj = Plan::findOrFail($id);
        $success = $obj->fill($data)->save();
        if($success){
            return response()->json('Plan Update Successfully');
        }else{
            return response()->json('System Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        abort_if(!Auth()->user()->can('plan.delete'), 401);
        $data = Plan::findOrFail($id);
        $data->delete();
        return  redirect()->back()->with('success','Plan Deleted Successfully');
    }
}
