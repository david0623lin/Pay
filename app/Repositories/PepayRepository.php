<?php

namespace App\Repositories;

use App\Models\Pepay;

class PepayRepository
{
    static public function getPepayProdID($mode)
    {
        $resp = Pepay::select('prod_id')->where('id', $mode)->get()->toArray();

        return $resp[0];
    }
}
