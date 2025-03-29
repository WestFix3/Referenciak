<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

use Exception;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            Room::factory(5)->create();
        } catch (Exception $e) {
            echo "Hiba történt: " . $e->getMessage();
        }
    }
}
