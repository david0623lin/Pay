<?php

namespace App\Repositories;

use App\Models\Orders;

class OrderRepository
{
    static public function add($datas)
    {
        Orders::insert($datas);
    }
}
