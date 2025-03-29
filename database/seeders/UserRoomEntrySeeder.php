<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\UserRoomEntry;

class UserRoomEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            // Ellenőrizzük, hogy van-e pozíciója
            if ($user->position) {
                // A pozícióhoz tartozó szobák
                $accessibleRooms = $user->position->rooms;

                // Ha vannak elérhető szobák, akkor létrehozzuk a UserRoomEntry rekordokat
                foreach ($accessibleRooms as $room) {
                    UserRoomEntry::create([
                        'user_id' => $user->id,
                        'room_id' => $room->id,
                        'successful' => false, // alapértelmezett érték, módosítható
                    ]);
                }
            } else {
                // Ha nincs pozíció, hozzunk létre alapértelmezett szobát, ha szükséges
                // Példa egy alapértelmezett szoba létrehozása
                $defaultRoom = Room::first(); // első szoba vagy egy alapértelmezett szoba
                if ($defaultRoom) {
                    UserRoomEntry::create([
                        'user_id' => $user->id,
                        'room_id' => $defaultRoom->id,
                        'successful' => false, // alapértelmezett érték
                    ]);
                }
            }
        }
    }
}
