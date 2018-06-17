<?php

namespace App\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Pair;

class Market extends Model
{
    use Notifiable;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'symbol', 'name', 'min_deposit', 'min_withdrawal', 'fee_withdrawal'
    ];

    public function getPairs() {
        return Pair::select('pairs.*', 'coins.symbol AS symbol')
            ->join('coins', 'pairs.coin_id', '=', 'coins.id')
            ->where('market_id', $this->id)
            ->get();
    }
}
