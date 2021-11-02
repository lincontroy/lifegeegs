<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->Middleware('guest');
    }

    public function login()
    {
        return view('admin.login');
    }
}
