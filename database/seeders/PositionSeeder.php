<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;
use App\Models\Room;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = Position::factory(4)->create();
        $rooms = Room::all();

        foreach ($positions as $position) {
            if ($rooms->isNotEmpty()) {
                $selectedRooms = $rooms->random(rand(1, 3));
                $position->rooms()->attach(
                    $selectedRooms->pluck('id')->toArray()
                );
            }
        }
    }
}
