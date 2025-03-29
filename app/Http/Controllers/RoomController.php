<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\UserRoomEntry;
use Illuminate\Routing\Controller; //middleware
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->except(['index']);
    }

    public function index()
    {
        $rooms = Room::with('positions')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $positions = Position::all();
        return view('rooms.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:rooms',
            'description' => 'nullable|string',
        ]);

        Room::create($request->all());

        return redirect()->route('rooms.index')->with('success', 'Szoba sikeresen létrehozva.');
    }

    public function edit(Room $room)
    {
        $positions = Position::all();

        return view('rooms.edit', compact('room', 'positions'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'positions' => 'required|array',
            'positions.*' => 'exists:positions,id',
        ]);

        $room->name = $validated['name'];
        $room->description = $validated['description'];

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::delete($room->image);
            }

            $imagePath = $request->file('image')->store('room_images', 'public');
            $room->image = $imagePath;
        }

        //$room->update($request->all());
        if ($request->has('positions')) {
            $room->positions()->sync($validated['positions']);
        }
        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Szoba sikeresen frissítve.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Szoba sikeresen törölve.');
    }
    public function entryHistory(Room $room)
    {
        $entries = UserRoomEntry::with('user', 'room')
            ->where('room_id', $room->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('rooms.entry-history', compact('entries', 'room'));
    }
}
