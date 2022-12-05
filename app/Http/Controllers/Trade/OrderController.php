<?php

namespace App\Http\Controllers\Trade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\Log;
use App\Http\Requests\Trade\PayRequest;
use App\Services\Trade\OrderService;

class OrderController extends Controller
{
    public function pay(PayRequest $payRequest, OrderService $orderService)
    {
        $inputs = $payRequest->only([
            'auth',
            'order_id',
            'payway',
            'item',
            'amount',
            'customer_id',
            'currency',
        ]);
        $outputs = $orderService->pay($inputs);
        Log::payment($payRequest, $outputs);

        return $outputs;
    }

    public function receive01(Request $request)
    {
        $pepay = new \App\Classes\Merchants\Pepay;
        return $pepay->receive01($request);
    }

    public function receive02(Request $request)
    {
        //
    }
}
