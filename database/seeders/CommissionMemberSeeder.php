<?php

namespace Database\Seeders;

use App\Models\CommissionMember;
use Illuminate\Database\Seeder;

class CommissionMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Directeur ENSA Khouribga',
                'role' => 'Directeur',
                'category' => 'académique',
                'position' => 'Président',
                'email' => null,
                'phone' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Responsable des affaires pédagogiques',
                'role' => 'Responsable pédagogique',
                'category' => 'académique',
                'position' => null,
                'email' => null,
                'phone' => null,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Enseignant-chercheur 1',
                'role' => 'Enseignant',
                'category' => 'académique',
                'position' => null,
                'email' => null,
                'phone' => null,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Représentant des clubs',
                'role' => 'Étudiant',
                'category' => 'étudiant',
                'position' => null,
                'email' => null,
                'phone' => null,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($members as $member) {
            CommissionMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
    }
}
