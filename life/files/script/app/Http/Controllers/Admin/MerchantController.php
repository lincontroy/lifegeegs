<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantRequest;
use App\Jobs\SendEmailJob;
use App\Mail\MerchantMail;
use App\Models\Plan;
use App\Models\User;
use App\Models\Userplan;
use App\Models\Order;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Auth;
use Carbon\Carbon;
class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|Response
     */
    public function index(Request $request)
    {
        abort_if(!Auth()->user()->can('merchant.index'), 401);
        $user = User::where('role_id', '2');
        $active = $user->where('status', '1')->count();
        $inactive = $user->where('status', '0')->count();
        $all = User::where('role_id', '2')->count();
        if (!empty($request->src)) {
           $data = User::where([['role_id', '2'],[$request->type,'LIKE','%'.$request->src.'%']])->latest()->paginate(20);
        }
        else{
           if ($request->has('1') || $request->has('0')) {
            if ($request->has('1')) {
                $data = User::where('role_id', '2')->where('status', '1')->latest()->paginate(20);
            } else {
                $data = User::where('role_id', '2')->where('status', '0')->latest()->paginate(20);
            }
            } else {
            $data = User::where('role_id', '2')->latest()->paginate(20);
            }
        }
       
        return view('admin.merchant.index', compact('data', 'active', 'inactive', 'all','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        abort_if(!Auth()->user()->can('merchant.create'), 401);
        return view('admin.merchant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MerchantRequest $request
     * @return JsonResponse
     */
    public function store(MerchantRequest $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',
            'password' => 'required|min:6',
        ]);
        DB::beginTransaction();
        try {
            //write your code here
            $obj = new User();
            $obj->password = Hash::make($request->password);
            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = isset($request->phone) ? $request->phone : null;

            $obj->public_key = $this->uniqkeyuser('public_key');
            $obj->private_key = $this->uniqkeyuser('private_key');
            $obj->currency = 'USD';
            $obj->role_id = 2;
            $success = $obj->save();
            // to save data in User plan table
           
            $userplan = new Userplan();
            $userplan->user_id = $obj->id;
            $userplan->name ='free';
            $userplan->storage_limit =  0;
            $userplan->captcha =  0;
            $userplan->menual_req =  0;
            $userplan->monthly_req =  0;
            $userplan->daily_req =  0;
            $userplan->mail_activity = 0;
            $userplan->fraud_check =  0;
            $userplan->captcha = 0;
            $userSuccess = $userplan->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        
        }

        if ($success && $userSuccess) {
            return response()->json('Merchant Created Successfully');
        } else {
            return response()->json('System Error');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = User::where('role_id',2)->findOrFail($id);
        $orders_total=Order::where('user_id',$id)->count();
        $profits=Order::where('user_id',$id)->sum('amount');
        $userplan=Userplan::where('user_id',$id)->first();
        $current_plan=Order::where([['user_id',$id],['status',1]])->latest()->first();
        $total_requests=\App\Models\Request::where('user_id',$id)->count();
        $current_month_requests=\App\Models\Request::where('user_id',$id)
        ->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->month)
        ->count();
        $today_requests=\App\Models\Request::where('user_id',$id)
        ->where('created_at', Carbon::today())
        ->count();

        $supports=\App\Models\Support::where('user_id',$id)->count();
        $orders = Order::with('plan', 'getway')->where('user_id',$id)->latest()->paginate(20);
        return view('admin.merchant.show', compact('data','orders','profits','userplan','current_plan','total_requests','current_month_requests','today_requests','supports','orders_total'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        abort_if(!Auth()->user()->can('merchant.edit'), 401);
        $data = User::findOrFail($id);
        return view('admin.merchant.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {   
        $obj = User::findOrFail($id);
        $obj->name=$request->name;
        $obj->email=$request->email;
        if ($request->password) {
            $obj->password=Hash::make($request->password);
        }
        $obj->status = $request->status;
        $success = $obj->save();
        if ($success) {
            return response()->json('Merchant Status Change Successfully');
        } else {
            return response()->json('System Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(!Auth()->user()->can('merchant.delete'), 401);
        $data = User::findOrFail($id);
        if (file_exists($data->image)) {
            unlink($data->image);
        }
        \File::deleteDirectory('uploads/'.$id);
        $data->delete();
        return redirect()->back()->with('success', 'Merchant Deleted Successfully');
    }

    public function sendMail($id, Request $request)
    {
        abort_if(!Auth()->user()->can('merchant.mail'), 401);
        $user = User::findOrFail($id);
        $data = [
            'email'   => $user->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'type'    => 'usermail',
        ];
        if (env('QUEUE_MAIL') == 'on') {
            dispatch(new SendEmailJob($data));
        } else {
            Mail::to($user->email)->send(new MerchantMail($data));
        }

        return response()->json('Email Sent Successfully !');
    }


    function uniqkeyuser($column){  
        $str = Str::random(50);
        $check = User::where($column, $str)->first();
        if($check == true){
            $str = $this->uniqkeyuser($column);
        }
        return $str;
    }

    public function login($id)
    {
        abort_if(!Auth()->user()->can('merchant.edit'), 401);
        $user=User::where('role_id',2)->findorFail($id);

        Auth::logout();
        Auth::loginUsingId($id);

        return redirect('/merchant/dashboard');
    }
}
