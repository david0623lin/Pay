<?php

namespace App\Classes;

class Encrypt
{
    static public function createOrderID($inputs)
    {
        $customer_id = $inputs['customer_id'];
        $time = time();

        return md5(implode('#', [$time, $customer_id]));
    }

    static public function pepay($type, $datas)
    {
        $shopID = env('PEPAY_SHOP_IP');
        $amount = $datas['AMOUNT'];
        $orderID = $datas['ORDER_ID'];
        $seesID = (array_key_exists('SESS_ID', $datas)) ? $datas['SESS_ID'] : '';
        $prodID = (array_key_exists('PROD_ID', $datas)) ? $datas['PROD_ID'] : '';
        $userID = (array_key_exists('USER_ID', $datas)) ? $datas['USER_ID'] : '';
        $sysTrustCode = env('PEPAY_SYS_TRUST_CODE');
        $shopTrustCode = env('PEPAY_SHOP_TRUST_CODE');

        switch ($type) {
            case 'Pepay':
                return md5(implode('#', [$sysTrustCode, $shopID, $orderID, $amount, $shopTrustCode]));
                break;
            case 'Receive01':
                return md5(implode('#', [$sysTrustCode, $shopID, $orderID, $amount, $seesID, $prodID, $shopTrustCode]));
                break;
            case 'Receive02':
                return md5(implode('#', [$sysTrustCode, $shopID, $orderID, $amount, $seesID, $prodID, $userID, $shopTrustCode]));
                break;
        }
    }
}
