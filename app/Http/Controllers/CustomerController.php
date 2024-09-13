<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\customer;

class CustomerController extends Controller
{
    public function GetCustomers()
    {
        if (Auth::check()) {
            return view('customer/customer');
        }
        else{
            return redirect('/sri-lanka-web-based-pos-system-software-signup');
        }
    }
}
