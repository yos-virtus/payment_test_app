<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payments\PaymentService;
use App\Exceptions\IncorrectHashSummException;
use App\Exceptions\UserBalanceUpdateException;

class Payment extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function __invoke($paymentProviderRoute, Request $request)
    {
        $paymentService = new PaymentService($paymentProviderRoute, $request->all());

        try {
            $paymentService->setTestMode();
            
            $paymentService->check();
            $paymentService->updateUserBalance();
            $response = $paymentService->response("Success");
        } catch (IncorrectHashSummException | UserBalanceUpdateException $e) {
            $response = $paymentService->response("Error");
        } 

        return view('payment', compact('response'));
    }
}
