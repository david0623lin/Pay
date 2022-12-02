<?php

namespace App\Services\Trade;

use App\Classes\Weight;
use App\Repositories\PaymentRepository;
use App\Repositories\PepayRepository;

class OrderService
{
    public function pay($inputs)
    {
        // 從權重快取中取得要使用的商戶
        $weight = new Weight;
        $merchant = $weight->get($inputs['payway']);
        
        $paymentID = PaymentRepository::getID($inputs['auth']);
        $inputs['payment_id'] = $paymentID['payment_id'];
        $inputs['merchant_id'] = $merchant['merchant_id'];
        $prodID = PepayRepository::getPepayProdID($inputs['payway']);
        $inputs['prod_id'] = $prodID['prod_id'];

        // 依照不同商戶執行付款流程
        switch ($merchant['name']) {
            case 'Pepay':
                $pepay = new \App\Classes\Merchants\Pepay;
                $outputs = $pepay->pay($inputs);
                break;
            default:
                // todo 無商戶情況錯誤
                return;
        }

        return $outputs;
    }
}
