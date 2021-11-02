<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Userplan;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    public function redirectTo()
    {
        if(Auth::check() && Auth::user()->role_id == 1) {
            return $this->redirectTo = route('admin.dashboard');
        } elseif(Auth::check() && Auth::user()->role_id == 2) {
            return $this->redirectTo = route('merchant.dashboard');
        }
        else {
            return $this->redirectTo = route('login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(env('NOCAPTCHA_SECRET') != null){
          return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => ['required', 'captcha'],
          ]);
        }

       return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
         
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'public_key' => $this->uniqkeyuser('public_key'),
                'private_key' => $this->uniqkeyuser('private_key'),
                'currency' => 'USD',
            ]);

            $userplan = new Userplan();
            $userplan->user_id = $user->id;
            $userplan->name = 'free';
            $userplan->storage_limit =  0;
            $userplan->captcha =  0;
            $userplan->menual_req =  0;
            $userplan->monthly_req =  0;
            $userplan->daily_req =  0;
            $userplan->mail_activity =  0;
            $userplan->fraud_check =  0;
            $userplan->captcha =  0;
            $userplan->save();
            DB::commit();
        } catch (Exception $e) {
          DB::rollback();
      }
        return $user;
    }


    function uniqkeyuser($column){  
        $str = Str::random(50);
        $check = User::where($column, $str)->first();
        if($check == true){
            $str = $this->uniqkeyuser($column);
        }
        return $str;
    }
}
