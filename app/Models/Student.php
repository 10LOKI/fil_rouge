<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'university', 'total_points', 'interests'];

    protected function casts(): array
    {
        return ['interests' => 'array'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
