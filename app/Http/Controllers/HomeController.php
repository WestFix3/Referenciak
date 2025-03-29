<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;

use Illuminate\Http\Request;

class HomeController extends Controller{
    public function index()
    {
        $roomCount = Room::count();

        $userCount = User::count();

        return view('home', compact('roomCount', 'userCount'));
    }
}
