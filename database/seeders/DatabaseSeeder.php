<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Partner;
use App\Models\Reward;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        $roles = ['admin', 'partner', 'student'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Admin
        User::create([
            'nom'      => 'Admin ActTogether',
            'email'    => 'admin@acttogether.com',
            'password' => Hash::make('password'),
        ])->assignRole('admin');

        // Partner
        $partnerUser = User::create([
            'nom'      => 'GreenCorp',
            'email'    => 'partner@greencorp.com',
            'password' => Hash::make('password'),
        ]);
        $partnerUser->assignRole('partner');

        $partner = Partner::create([
            'user_id'      => $partnerUser->id,
            'company_name' => 'GreenCorp',
            'rse_bio'      => 'Entreprise engagée pour l\'environnement.',
        ]);

        // Events
        foreach ([
            ['title' => 'Journée à l\'orphelinat', 'category' => 'Social',    'points_worth' => 20, 'status' => 'active'],
            ['title' => 'Nettoyage de plage',       'category' => 'Écologie', 'points_worth' => 15, 'status' => 'active'],
            ['title' => 'Refuge animalier',          'category' => 'Animaux',  'points_worth' => 10, 'status' => 'active'],
        ] as $e) {
            $partner->events()->create(array_merge($e, ['date_event' => now()->addDays(rand(5, 30))]));
        }

        // Rewards
        $partner->rewards()->createMany([
            ['label' => 'Bon d\'achat 10€',  'cost_points' => 50,  'promo_code' => 'GREEN10',  'stock_quantity' => 20],
            ['label' => 'Café offert',        'cost_points' => 20,  'promo_code' => 'CAFE2024', 'stock_quantity' => 50],
            ['label' => 'T-shirt GreenCorp', 'cost_points' => 100, 'promo_code' => 'SHIRT100', 'stock_quantity' => 10],
        ]);

        // Student
        $studentUser = User::create([
            'nom'      => 'Alice Dupont',
            'email'    => 'alice@student.com',
            'password' => Hash::make('password'),
        ]);
        $studentUser->assignRole('student');

        Student::create([
            'user_id'      => $studentUser->id,
            'university'   => 'Université Paris 1',
            'total_points' => 75,
            'interests'    => ['Social', 'Écologie'],
        ]);
    }
}
