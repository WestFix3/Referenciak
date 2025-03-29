<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'phone_number',
        'card_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'admin' => 'boolean',
        ];
    }

    // Kapcsolatok
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function entries()
    {
        return $this->hasMany(UserRoomEntry::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'user_room_entries');
    }

    public function userRoomEntries()
    {
        return $this->hasMany(UserRoomEntry::class);
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->phone_number) || empty($user->card_number)) {
                $user->phone_number = '1234567890'; // alapértelmezett érték
                $user->card_number = 'abcd1234abcd1234'; // alapértelmezett érték
            }
        });
    }
}
