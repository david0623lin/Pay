<?php

namespace App\Classes\Merchants;

use Ixudra\Curl\Facades\Curl;
use App\Classes\Encrypt;
use App\Repositories\OrderRepository;
use App\Classes\Log;

class Pepay
{
    const REQUEST_URL = 'https://gate.pepay.com.tw/pepay/paysel_amt.php';
    const REQUEST_STATUS = 0;
    const RECEIVE01_STATUS = 1;
    const RECEIVE02_STATUS = 2;

    public function pay($inputs)
    {
        $url = self::REQUEST_URL;
        $datas['SHOP_ID'] = env('PEPAY_SHOP_IP');
        $datas['ORDER_ID'] = $inputs['order_id'];
        $datas['ORDER_ITEM'] = urlencode($inputs['item']);
        $datas['AMOUNT'] = $inputs['amount'];
        $datas['CURRENCY'] = $inputs['currency'];
        $datas['PROD_ID'] = $inputs['prod_id'];
        $datas['CHECK_CODE'] = Encrypt::pepay('Pepay', $datas);

        try {
            $response = Curl::to($url)->withData($datas)->withResponseHeaders()->returnResponseObject()->post();
        } catch (\Throwable $th) {
            //throw $th;
        }

        if (strpos($response->content, 'shoproute_amt.php') >= 1) {
            $order = [
                'order_id' => $inputs['order_id'],
                'merchant_id' => $inputs['merchant_id'],
                'payment_id' => $inputs['payment_id'],
                'item' => $inputs['item'],
                'customer_id' => $inputs['customer_id'],
                'amount' => $inputs['amount'],
                'status' => self::REQUEST_STATUS,
                'currency' => $inputs['currency'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            OrderRepository::add($order);
        }
        Log::write(
            $inputs['order_id'], 'Merchant', 'System', 'POST', $url, [], $datas, $response
        );

        return $response;
    }

    public function receive01($inputs)
    {
        $userID = '123456';
        $resCode = 0;
        $checkCode = Encrypt::pepay('Receive01', $inputs);

        if ($inputs['CHECK_CODE'] != $checkCode) {
            $resCode = 20001;
        }
        return "USER_ID={$userID}&RES_CODE={$resCode}";
    }

    public function receive02($inputs)
    {
        $resCode = 0;
        $checkCode = Encrypt::pepay('Receive02', $inputs);

        if ($inputs['CHECK_CODE'] != $checkCode) {
            $resCode = 20001;
        }
        return "RES_CODE={$resCode}";
    }
}
