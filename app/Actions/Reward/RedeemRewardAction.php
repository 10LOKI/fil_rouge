<?php

namespace App\Actions\Reward;

use App\Models\Reward;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Str;

class RedeemRewardAction
{
    public function handle(Student $student, Reward $reward): Transaction
    {
        if ($student->total_points < $reward->cost_points) {
            throw new \RuntimeException('Points insuffisants.');
        }

        if ($reward->stock_quantity <= 0) {
            throw new \RuntimeException('Récompense épuisée.');
        }

        $transaction = Transaction::create([
            'student_id'  => $student->id,
            'reward_id'   => $reward->id,
            'redeemed_at' => now(),
            'unique_code' => strtoupper(Str::random(10)),
        ]);

        $student->decrement('total_points', $reward->cost_points);
        $reward->decrement('stock_quantity');

        return $transaction;
    }
}
