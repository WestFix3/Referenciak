<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function index(User $user)
    {
        // Lekérjük a felhasználó belépéseit
        $entries = $user->userRoomEntries()->with('room')->get();

        return view('entries.index', compact('user', 'entries'));
    }
}