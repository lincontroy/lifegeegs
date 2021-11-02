<?php

namespace App\Http\Controllers\Merchant;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Request as PaymentRequest;
use App\Models\Userplan;

class DashboardController extends Controller
{

    public function index()
    {
        return view('merchant.dashboard');
    }

    public function keysupdate(Request $request){
        $id = Auth()->user()->id;
        $request->validate([
            'currency' => 'required',
            'public_key' => 'required|unique:users,public_key,'.$id,
            'private_key' => 'required|unique:users,private_key,'.$id,
        ]);
        
        if($request->public_key == $request->private_key){
            $error['errors']['err']= 'Private and Public keys cannot be same!';
            return response()->json($error,401); 
        }

        $obj = User::findOrFail($id);
        $obj->public_key = $request->public_key;
        $obj->private_key = $request->private_key;
        $obj->currency = strtoupper($request->currency);
        $obj->save();
  
        return response()->json('Updated Successfully');
        
    }

    public function earning($day)
    {
        if ($day != 365) {
            $payment = Payment::whereDate('created_at', '>', Carbon::now()->subDays($day))
            ->orderBy('id', 'asc')
            ->selectRaw('year(created_at) year, date(created_at) date, sum(main_amount) as amount')
            ->groupBy('year','date')
            ->where('user_id', Auth::id())
            ->get();
        }
        else{
            $payment =  Payment::where('user_id', Auth::id())
            ->select(DB::raw('SUM(main_amount) as amount'),
            DB::raw('YEAR(created_at) year'),
            DB::raw('MONTH(created_at) month'))
            ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
            ->where('created_at', '>=', Carbon::now()->subDays($day))
            ->get();
        }
         
        return $payment;
    }

    public function stats()
    {
        $stats['daily_request'] = PaymentRequest::where('user_id',Auth::id())->whereDate('created_at',Carbon::today())->count();
        $stats['monthly_request'] = PaymentRequest::where('user_id',Auth::id())->whereMonth('created_at',Carbon::now()->month)->count();
        $stats['user_plan'] = Userplan::where('user_id',Auth::id())->first();
        $stats['storage']=number_format(folderSize('uploads/'.Auth::id()),2).'/'.$stats['user_plan']->storage_limit;
        $stats['recent_payments'] =Payment::with('getway', 'user')->where('user_id', Auth::id())->latest()->take(15)->get();
        $stats['total_earning'] = Payment::where('user_id', Auth::id())->sum('main_amount');
        $order = Order::where([
            ['user_id',Auth::User()->id],
            ['status',1]
        ])->latest()->first();
        if($order)
        {
            $stats['expire_date'] = $order->exp_date;
        }else{
            $stats['expire_date'] = false;
        }
        $stats['total_requests'] = PaymentRequest::where('user_id', Auth::id())->count('id');
        $stats['total_payments'] = Payment::where('user_id', Auth::id())->count('id');
        return $stats;
    }


    function uniqkeyuser($column){  
        $str = Str::random(50);
        $check = User::where($column, $str)->first();
        if($check == true){
            $str = $this->uniqkeyuser($column);
        }
        return response()->json($str);
    }
}
