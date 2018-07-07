<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    public $timestamps = false;

    public static function findBySymbol($symbol)
    {
        return Coin::where('symbol', $symbol)->first();
    }
}
