<?php

namespace App\Repositories;

use App\Models\Payments;

class PaymentRepository
{
    static public function getAll()
    {
        return Payments::all();
    }

    static public function getID($key)
    {
        $resp = Payments::where('key', $key)->get()->toArray();

        return $resp[0];
    }
}
