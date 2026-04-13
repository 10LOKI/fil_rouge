<?php

namespace App\Actions\Event;

use App\Models\Event;
use App\Models\Participation;
use App\Models\Student;

class JoinEventAction
{
    public function handle(Student $student, Event $event): Participation
    {
        if (Participation::where('student_id', $student->id)->where('event_id', $event->id)->exists()) {
            throw new \RuntimeException('Vous êtes déjà inscrit à cet événement.');
        }

        return Participation::create([
            'student_id'   => $student->id,
            'event_id'     => $event->id,
            'joined_at'    => now(),
            'is_validated' => false,
        ]);
    }
}
