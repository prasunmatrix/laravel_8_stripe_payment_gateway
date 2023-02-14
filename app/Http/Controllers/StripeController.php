<?php

namespace App\Http\Controllers;

use Session;
use Stripe;

use Illuminate\Http\Request;

class StripeController extends Controller
{
  //
  public function stripe()
  {
    return view('stripepayment.stripe');
  }

  public function stripePost(Request $request)
  {
    $stripe = new \Stripe\StripeClient(
      'sk_test_51L6YYuSEhIE3c7huqme1fSSoTTcrh7hwQ5T9d9yAEJKcoSklIcal08kqf1jPEYTPOIatE6Ak7WTfsgJdyLdtF94e00J5yE2Tqv'
    );
    // Stripe\Charge::create([
    //   "amount" => 100,
    //   "currency" => "USD",
    //   "source" => $request->stripeToken,
    //   "description" => "This is test payment",
    // ]);
    $stripe->paymentIntents->create([
      'amount' => 200,
      'currency' => 'usd',
      'automatic_payment_methods' => [
        'enabled' => true,
      ],
    ]);

    Session::flash('success', 'Payment Successful !');

    return back();
  }
}
