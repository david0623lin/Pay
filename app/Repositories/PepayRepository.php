<?php

namespace App\Repositories;

use App\Models\Pepay;

class PepayRepository
{
    static public function getPepayProdID($mode)
    {
        return Pepay::select('prod_id')->where('id', $mode)->get()->toArray();
    }
}
