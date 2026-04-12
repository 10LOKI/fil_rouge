<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['partner_id', 'title', 'category', 'date_event', 'points_worth', 'status'];

    protected function casts(): array
    {
        return ['date_event' => 'datetime'];
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
}
