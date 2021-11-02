<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Request as PaymentRequest;


class DashboardController extends Controller
{
    public function index()
    {
        $data = Order::with('plan', 'getway', 'user')->get();
        $all = $data->count();
        $active = Order::where('status', '1')->count();
        $inactive = Order::where('status', '0')->count();
        $pending = Order::where('status', '3')->count();
        $expired = Order::where('status', '2')->count();
        $expiredOrders = Order::with('plan', 'getway', 'user')->where('status', '2')->latest()->limit(20)->get();
        $pendingOrders = Order::with('plan', 'getway', 'user')->where('status', '3')->latest()->limit(20)->get();
        $orders = Order::with('plan', 'getway', 'user')->latest()->limit(15)->get();
        $activeMerchant = User::where('role_id', '2')->where('status', '1')->count();
        $requests = PaymentRequest::with('user')->where('status', '1')->latest()->limit(10)->get();
        return view('admin.dashboard', compact('all', 'requests', 'active', 'inactive', 'pending', 'expired', 'activeMerchant', 'orders', 'expiredOrders', 'pendingOrders'));
    }

    public function data(Request $request)
    {
        $day = $request->id;
        if ($request->id != 365) {
            $payment = Payment::whereDate('created_at', '>', Carbon::now()->subDays($day))
            ->orderBy('id', 'asc')
            ->selectRaw('year(created_at) year, date(created_at) date, count(*) amount')
            ->groupBy('year','date')
            ->get();
        }
        else{
            $payment =  Payment::select(DB::raw('count(*) as amount'),
            DB::raw('YEAR(created_at) year'),
            DB::raw('MONTH(created_at) month'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->where('created_at', '>=', Carbon::now()->subDays($day))
            ->get();
        }
       
        return $payment;
    }

    public function plandata(Request $request)
    {
        $day = $request->id;
        if ($request->id != 365) {
            $plan = Order::where('status',1)->where('created_at', '>=', Carbon::now()->subDays($day))->selectRaw('DATE(created_at) as date, amount')->get();
        }
        else{
            $plan =  Order::where('status',1)
            ->select(DB::raw('SUM(amount) as amount'),
            DB::raw('YEAR(created_at) year'),
            DB::raw('MONTH(created_at) month'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->where('created_at', '>=', Carbon::now()->subDays($day))
            ->get();
        }
       
        return $plan;
    }
}
