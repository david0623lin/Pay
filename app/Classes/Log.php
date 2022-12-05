<?php

namespace App\Classes;

use App\Repositories\LogRepository;

class Log
{
    static public function payment($apiDatas, $apiResponse)
    {
        $method = $apiDatas->method();
        $url = $apiDatas->url();
        $header = $apiDatas->header();
        $all = $apiDatas->all();

        $log = [
            'order_id' => $all['order_id'],
            'type' => 'Payment',
            'method' => $method,
            'url' => $url,
            'header' => json_encode($header),
            'body' => json_encode($all),
            'response' => json_encode($apiResponse),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        LogRepository::add($log);
    }

    static public function merchant($orderID, $method, $url, $apiDatas, $apiResponse)
    {
        $log = [
            'order_id' => $orderID,
            'type' => 'Merchant',
            'method' => $method,
            'url' => $url,
            'header' => json_encode($apiResponse->headers),
            'body' => json_encode($apiDatas),
            'response' => json_encode($apiResponse->content),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        LogRepository::add($log);
    }
}
