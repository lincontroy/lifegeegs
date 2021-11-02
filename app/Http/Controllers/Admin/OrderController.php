<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Mail\OrderMail;
use App\Mail\OrderMailExpired;
use App\Mail\TestMail;
use App\Models\Getway;
use App\Models\Option;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Models\Userplan;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('order.index'), 401);
        $all = Order::count();
        $active = Order::where('status', '1')->count();
        $inactive = Order::where('status', '0')->count();
        $pending = Order::where('status', '3')->count();
        $expired = Order::where('status', '2')->count();
        $st = '';
        

        if (!empty($request->src)) {
            $orders = Order::with('plan', 'getway', 'user')->where('payment_id',$request->src)->latest()->paginate(20);
        }
        else{
            if ($request->has('1') || $request->has('0') || $request->has('3') || $request->has('2')) {
                if ($request->has('1')) {
                    $st = '1';
                    $orders = Order::with('plan', 'getway', 'user')->where('status', '1')->latest()->paginate(20);
                }elseif ($request->has('3')) {
                    $st = '3';
                    $orders = Order::with('plan', 'getway', 'user')->where('status', '3')->latest()->paginate(20);
                }elseif ($request->has('2')) {
                    $st = '2';
                    $orders = Order::with('plan', 'getway', 'user')->where('status', '2')->latest()->paginate(20);
                }else {
                    $st = '0';
                    $orders = Order::with('plan', 'getway', 'user')->where('status', '0')->latest()->paginate(20);
                }
            } else {
                $orders = Order::with('plan', 'getway', 'user')->latest()->paginate(20);
            }
        }
        return view('admin.order.index', compact('orders','active','inactive','all','pending','expired','st','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $plans = Plan::where('status', 1)->get();
        $getways = Getway::all();
        return view('admin.order.create', compact('plans','getways'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'plan_id'    => 'required',
            'getway_id'  => 'required',
            'email'      => 'required',
            'payment_id' => 'required',
        ]);

        $user = User::where('email',$request->email)->first();
        $plan = Plan::where('id',$request->plan_id)->first();
        $getway = Getway::where('id',$request->getway_id)->first();

        if(!$user) {
            $msg['errors']['error'] = "User Not Found";
            return response()->json($msg, 401);
        }

        $order = new Order;
        $order->plan_id = $request->plan_id;
        $order->user_id = $user->id;
        $order->getway_id = $request->getway_id;
        $order->payment_id = $request->payment_id;
        $order->amount = $plan->price;
        $order->status = 1;
        $order->payment_status = 1;
        $order->exp_date = Carbon::now()->addDays($plan->duration);
        $order->save();

        $userplan = Userplan::where('user_id', $order->user_id)->first();

        if (!$userplan) {
            $userplan = new Userplan;
        }

        $userplan->name = $plan->name;
        $userplan->user_id = $order->user_id;
        $userplan->storage_limit = $plan->storage_limit;
        $userplan->menual_req = $plan->menual_req;
        $userplan->daily_req = $plan->daily_req;
        $userplan->monthly_req = $plan->monthly_req;
        $userplan->mail_activity = $plan->mail_activity;
        $userplan->fraud_check = $plan->fraud_check;
        $userplan->save();

        if ($request->email_status == '1') {
            $data = [
                'type' => 'order',
                'email' => $user->email,
                'name' =>  $user->name,
                'price' => $plan->price,
                'plan' => $plan->name,
                'payment_id' => $order->payment_id,
                'payment_getway' => $getway->name,
                'created_at' => $userplan->updated_at,
            ];

            if (env('QUEUE_MAIL') == 'on') {
                dispatch(new SendEmailJob($data));
            }else{
                Mail::to($user->email)->send(new OrderMail($data));
            }
        }

        return response()->json('Order Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.show',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('order.edit'), 401);
        $plans = Plan::where('status', 1)->get();
        $getways = Getway::all();
        $order = Order::findOrFail($id);
        return view('admin.order.edit',compact('order','plans','getways'));
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
        $current_status=null;
        $getway = Getway::findOrFail($request->getway_id);
        $user = User::where('email', $request->email)->first();
        $order = Order::findOrFail($id);
        $current_status=$order->status;

        $plan = Plan::findOrFail($order->plan_id);
        $order->getway_id = $request->getway_id;
        $order->user_id = $user->id;
        $order->payment_id = $request->payment_id;
        $order->amount = $plan->price;
        $order->status = $request->status;
        $order->payment_status = $request->payment_status;
        $order->exp_date = Carbon::now()->addDays($plan->duration);
        $order->save();

        $userplan = Userplan::where('user_id', $order->user_id)->first();

        if ($current_status != 1 && $request->status == 1) {
            if (!$userplan) {
                $userplan = new Userplan;
            }

            $userplan->name = $plan->name;
            $userplan->user_id = $user->id;
            $userplan->storage_limit = $plan->storage_limit;
            $userplan->menual_req = $plan->menual_req;
            $userplan->daily_req = $plan->daily_req;
            $userplan->monthly_req = $plan->monthly_req;
            $userplan->mail_activity = $plan->mail_activity;
            $userplan->fraud_check = $plan->fraud_check;
            $userplan->save();
        }
        

        if ($request->email_status == '1') {
            $data = [
                'type' => 'order',
                'email' => $user->email,
                'name' =>  $user->name,
                'price' => $plan->price,
                'plan' => $plan->name,
                'payment_id' => $order->payment_id,
                'payment_getway' => $getway->name,
                'created_at' => $userplan->updated_at,
            ];

            if (env('QUEUE_MAIL') == 'on') {
                dispatch(new SendEmailJob($data));
            }else{
                Mail::to($user->email)->send(new OrderMail($data));
            }
        }
        return response()->json('Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('order.delete'), 401);
    }

    public function alertUserAfterExpiredOrder(){
        
         $expirable_order = Order::where('exp_date','<=' ,Carbon::today())->where('status', 1)->get();
         $expirable_userids = [];
         foreach ($expirable_order as $value) {
             array_push($expirable_userids, $value->user_id);
         }
 

         Order::where('exp_date','<=' ,Carbon::today())->update(array('status' => 2)); //expired
         $option = Option::where('key','cron_option')->first();
         $cron_option = json_decode($option->value);
         $users = User::where('role_id', 2)->withCount('active_orders','orders')->get();
         $plan = Plan::where('is_default', 1)->first();
         $ids = [];
         $emails = [];
         $names = [];
 

         foreach ($users as $value) {
             if ($value->active_orders_count == 0 && in_array($value->id, $expirable_userids)) {
                array_push($ids, $value->id);
                array_push($emails, $value->email);
                array_push($names, $value->name);
             }  
         }


         if ($cron_option->assign_default_plan == "on" && !empty($ids)) {
             $data = [
                'name' => $plan->name ?? 'free',
                'storage_limit' => $plan->storage_size ?? 0,
                'captcha' => $plan->user_limit ?? 0,
                'menual_req' => $plan->group_limit ?? 0,
                'monthly_req' => $plan->gps ?? 0,
                'daily_req' => $plan->screenshot ?? 0,
                'mail_activity' => $plan->is_featured ?? 0,
                'fraud_check' => $plan->is_featured ?? 0,
             ];
             Userplan::whereIn('user_id', $ids)->update($data);
         }

         if ($emails) {
             foreach ($emails as $key => $value) {
                 $mail_data = [
                     'type' => 'order_expired',
                     'email' => $value,
                     'name' =>  $names[$key],
                     'message' => $cron_option->expire_message
                 ];

                 if (env('QUEUE_MAIL') == 'on') {
                     dispatch(new SendEmailJob($mail_data));
                 }else{
                     Mail::to($value)->send(new OrderMailExpired($mail_data)); 
                 }
             }
         }
 
         return "success";
     }
 
     public function alertUserBeforeExpiredOrder(){
     
        
         //before expired how many days left
         $option = Option::where('key','cron_option')->first();
         $cron_option = json_decode($option->value);
         $expiry_date = Carbon::now()->addDays($cron_option->days - 2)->format('Y-m-d');
         $orders = Order::where('exp_date', '<=', $expiry_date)->where('status', 1)->get(); 
         foreach ($orders as $value) {
             $user = User::findOrFail($value->user_id);
             $data = [
                 'type' => 'order_expired_alert',
                 'Plan Name'=>$value->plan->name , 
                 'Name' =>  $user->name,
                 'Expire Date' =>  $value->exp_date,
                 'Message' => $cron_option->alert_message
             ];
        
             if (env('QUEUE_MAIL') == 'on') {
                 dispatch(new SendEmailJob($data));
             }else{
                 Mail::to($user->email)->send(new OrderMailExpired($data)); 
             }
         }
 
         return "success";
     }
}
