<?php

namespace App\Http\Controllers\Trade;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trade\PayRequest;
use App\Services\Trade\OrderService;
use App\Classes\Log;

class OrderController extends Controller
{
    public function pay(PayRequest $payRequest, OrderService $orderService)
    {
        $method = $payRequest->method();
        $url = $payRequest->url();
        $header = $payRequest->header();
        $all = $payRequest->all();
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
        Log::write($inputs['order_id'], 'Payment', 'System', $method, $url, $header, $all, $outputs);

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
