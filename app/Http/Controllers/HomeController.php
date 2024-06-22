<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $user = auth()->user();
        return view('dashboard', [
            'intent' => $user->createSetupIntent(),
        ]);
    }

    public function singleCharge(Request $request){
        // return $request->all();

        $amount = $request->amount;
        $user = auth()->user();
        $intent = $user->createSetupIntent();
        $clientSecret = $intent->client_secret;
        return view('dashboard', compact('clientSecret', 'amount'));

        // $amount = $request->amount;
        // $paymentMethod = $request->payment_method;

        // $user = auth()->user();
        // $request->charge($amount, $paymentMethod);

        // return to_route('dashboard');
    }
}


