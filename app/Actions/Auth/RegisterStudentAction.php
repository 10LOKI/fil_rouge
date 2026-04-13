<?php

namespace App\Actions\Auth;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterStudentAction
{
    public function handle(array $data): User
    {
        $user = User::create([
            'nom'      => $data['nom'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole('student');

        Student::create([
            'user_id'    => $user->id,
            'university' => $data['university'],
            'interests'  => $data['interests'] ?? [],
        ]);

        return $user;
    }
}
