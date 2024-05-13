<?php

namespace Database\Seeders;

use App\Models\IndividualIntern;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        foreach($users as $user) {
            $intern = IndividualIntern::factory()->for($user)->create();
        }
    }
}
