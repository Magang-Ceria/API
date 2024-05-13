<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Date;
use App\Models\Group;
use App\Models\GroupIntern;
use App\Models\IndividualIntern;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = Group::factory()
            ->has(GroupIntern::factory(4))
            ->for(User::factory(), 'leader')
            ->create();

        $individualInternUsers = User::factory(10)->create();

        foreach ($individualInternUsers as $leader) {
            $individualInterns[] = IndividualIntern::factory()
                ->for($leader)
                ->create();
        }

        $date = Date::factory()->create();

        foreach ($individualInterns as $intern) {
            $IndividualInternAttendances = Attendance::factory()
                ->for($intern, 'attendanceable')->for($date, 'date')->create();
        }

        $groupInternAttendance = Attendance::factory()
            ->for($group, 'attendanceable')->for($date, 'date')->create();
    }
}
