<?php

namespace App\Actions\Event;

use App\Models\Participation;

class ValidateParticipationAction
{
    public function handle(Participation $participation): void
    {
        if ($participation->is_validated) {
            throw new \RuntimeException('Participation déjà validée.');
        }

        $participation->update(['is_validated' => true]);

        $participation->student->increment('total_points', $participation->event->points_worth);
    }
}
