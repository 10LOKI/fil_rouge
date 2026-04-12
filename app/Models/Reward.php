<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = ['partner_id', 'label', 'cost_points', 'promo_code', 'stock_quantity'];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
