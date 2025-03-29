<?php

namespace Database\Factories;

use App\Models\UserRoomEntry;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserRoomEntryFactory extends Factory
{
    protected $model = UserRoomEntry::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'successful' => $this->faker->boolean,
        ];
    }
}
