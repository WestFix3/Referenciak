<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_room');
    }

    public function entries()
    {
        return $this->hasMany(UserRoomEntry::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_room_entries');
    }
}
