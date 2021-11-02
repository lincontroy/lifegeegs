<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocumentationController extends Controller
{
    public function index()
    {
        return view('docs.docs');
    }

    public function payment_install()
    {
        return view('docs.payment_install');
    }

    public function form_generator()
    {
        return view('docs.form_generator');
    }

    public function payment_url()
    {
        return view('docs.payment_url');
    }

    public function payment_api()
    {
        return view('docs.payment_api');
    }

    public function thankyou()
    {
        return view('docs.thankyou');
    }
}
