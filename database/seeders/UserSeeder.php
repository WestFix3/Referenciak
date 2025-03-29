<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Position;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::all();

        User::factory(10)->create()->each(function ($user) use ($positions) {
            $user->position()->associate($positions->random());
            $user->save();
        });
    }
}
