<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function store(Request $request)
    {
        Session::put('locale',$request->value);
        return response()->json('success');
    }
}
