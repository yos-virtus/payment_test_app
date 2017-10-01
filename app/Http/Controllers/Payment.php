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
    public function __invoke($paymentProvider, Request $request)
    {
        $paymentService = new PaymentService($paymentProvider, $request);

        try {

            $paymentService->check();
            $paymentService->updateUserBalance();
            $paymentService->response("Success");

        } catch (IncorrectHashSummException $e1) {
            $paymentService->response("Error");
        } catch (UserBalanceUpdateException $e2 ) {
            $paymentService->response("Error");
        }
    }
}
