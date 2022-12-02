<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    static public function add($datas)
    {
        Log::insert($datas);
    }
}
