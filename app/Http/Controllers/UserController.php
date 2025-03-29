<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        //Itt történik, hogy a felhasználó admin-e (Dolgozók létrehozása pontban)
        if (!Auth::check() || !Auth::user()->admin) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function create()
    {
        $positions = Position::all();
        return view('users.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'card_number' => 'required|string|size:16|regex:/^[0-9a-zA-Z]+$/',
            'position_id' => 'required|exists:positions,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_number' => $validated['phone_number'],
            'card_number' => $validated['card_number'],
            'position_id' => $validated['position_id'],
        ]);

        return redirect()->route('users.index')->with('success', 'Dolgozó sikeresen létrehozva.');
    }
}