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
      'sk_test_51OTn9tSDO2xiPnDDwCihyUFdE6YVohkH6N8tFeGSmjEdpGSlthcVLirmJNjdr42O28Kr2BwR7zzGYkd6r0VYxt7500rE81qiul'
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
