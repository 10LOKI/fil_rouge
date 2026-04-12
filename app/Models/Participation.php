<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = ['student_id', 'event_id', 'joined_at', 'is_validated'];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
            'is_validated' => 'boolean',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
