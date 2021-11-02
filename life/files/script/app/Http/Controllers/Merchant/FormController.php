<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormController extends Controller
{
   public function generate()
   {
       return view('merchant.form.create');
   }
}
