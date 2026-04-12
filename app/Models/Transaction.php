<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['student_id', 'reward_id', 'redeemed_at', 'unique_code'];

    protected function casts(): array
    {
        return ['redeemed_at' => 'datetime'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
}
