<?php

namespace App\Repositories;

use App\Models\Merchants;

class MerchantRepository
{
    static public function getAll()
    {
        return Merchants::all();
    }
}
