<?php

namespace App\Classes;

use App\Repositories\LogRepository;

class Log
{
    static public function write($orderID, $type, $operator, $method, $url, $header = [], $body = [], $resopnse = [])
    {
        $datas = [
            'order_id' => $orderID,
            'type' => $type,
            'operator' => $operator,
            'method' => $method,
            'url' => $url,
            'header' => json_encode($header),
            'body' => json_encode($body),
            'response' => json_encode($resopnse),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        LogRepository::add($datas);
    }
}
