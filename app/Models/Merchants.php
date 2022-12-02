<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchants extends Model
{
    protected $table = 'merchants';
    protected $primaryKey  = 'merchant_id ';
    public $timestamps = false;
}
