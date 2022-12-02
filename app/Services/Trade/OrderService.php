<?php

namespace App\Services\Trade;

use App\Classes\Weight;
use App\Repositories\PaymentRepository;

class OrderService
{
    public function pay($inputs)
    {
        $weight = new Weight;

        if ($weight->exists($inputs['payway'])) {
            $merchant = $weight->get($inputs['payway']);
        } else {
            $weight->create($inputs['payway']);
            $merchant = $weight->get($inputs['payway']);
        }
        $paymentID = PaymentRepository::getID($inputs['auth']);
        $inputs['payment_id'] = $paymentID['payment_id'];
        $inputs['merchant_id'] = $merchant['merchant_id'];

        return $inputs;

        switch ($merchant['name']) {
            case 'Pepay':
                $pepay = new \App\Classes\Merchants\Pepay;
                $pepay->pay($inputs);
                break;
            default:
                // todo 無商戶情況錯誤
                return;
        }
    }
}
