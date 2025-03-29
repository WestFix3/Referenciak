<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class PositionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        $positions = Position::with('rooms', 'users')->get();
        return view('positions.index', compact('positions'));
        if (Gate::allows('create', Position::class)) {
            Log::debug('User can create positions');
        }
    
        if (Gate::allows('update', $position)) {
            Log::debug('User can update the position');
        }
    
        if (Gate::allows('delete', $position)) {
            Log::debug('User can delete the position');
        }
    }

    public function create()
    {
        return view('positions.create');
    }

    public function store(Request $request)
    {
        //Log::debug('User admin status: ' . (Auth::user()->is_admin ? 'Yes' : 'No'));
        $request->validate([
            'name' => 'required|unique:positions|string|max:255',
        ]);

        Position::create($request->all());

        return redirect()->route('positions.index')->with('success', 'Munkakör sikeresen létrehozva.');
    }

    public function edit(Position $position)
    {
        //Log::debug('User admin status: ' . (Auth::user()->is_admin ? 'Yes' : 'No')); 

        //$this->authorize('update', $position);

        return view('positions.edit', compact('position'));
    }

    public function update(Request $request, Position $position)
    {
        //$this->authorize('update', $position);//nem tudom kell-e
        $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
        ]);

        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Munkakör sikeresen frissítve.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->route('positions.index')->with('success', 'Munkakör sikeresen törölve.');
    }

    // Ha van lehetőség a dolgozók részletes listázására
    public function show(Position $position)
    {
        $users = $position->users;
        return view('positions.show', compact('position', 'users'));
    }
}
