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
        $apiDatas['SHOP_ID'] = env('PEPAY_SHOP_IP');
        $apiDatas['ORDER_ID'] = $inputs['order_id'];
        $apiDatas['ORDER_ITEM'] = urlencode($inputs['item']);
        $apiDatas['AMOUNT'] = $inputs['amount'];
        $apiDatas['CURRENCY'] = $inputs['currency'];
        $apiDatas['PROD_ID'] = $inputs['prod_id'];
        $apiDatas['CHECK_CODE'] = Encrypt::pepay('Pepay', $apiDatas);

        try {
            $apiResponse = Curl::to(self::REQUEST_URL)->withData($apiDatas)->withResponseHeaders()->returnResponseObject()->post();
        } catch (\Throwable $th) {
            //throw $th;
        }

        if (strpos($apiResponse->content, 'shoproute_amt.php') >= 1) {
            // 成功就寫到order表
            $insertDatas = [
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
            OrderRepository::add($insertDatas);
        }
        Log::merchant(
            $inputs['order_id'], 'POST', self::REQUEST_URL, $apiDatas, $apiResponse
        );

        return $apiResponse->content;
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
