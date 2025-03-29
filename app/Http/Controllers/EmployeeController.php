<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRoomEntry;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::with('position')->get();
        return view('employees', compact('employees'));
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['edit', 'update', 'destroy']);
    }

    public function create()
    {
        $positions = Position::all();
        return view('employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        //Logolás
        Log::debug('Store metódus: ' . json_encode($request->all()));

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:15',
            'card_number' => 'required|string|size:16|regex:/^[0-9a-zA-Z]+$/',
            'position_id' => 'required|exists:positions,id',
        ]);

        $admin = $request->has('admin') ? true : false;

        $employee = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),   
            'phone_number' => $validated['phone_number'],
            'card_number' => $validated['card_number'],
            'position_id' => $validated['position_id'],
            'admin' => $admin,
        ]);

        // Ellenőrizzük, hogy sikerült-e a mentés
        Log::debug('Felhasználó mentve: ' . json_encode($employee));

        return redirect()->route('employees.index')->with('success', 'Dolgozó sikeresen létrehozva.');
    }

    public function edit(User $employee)
    {
        // Pozíciók lekérdezése a pozícióválasztáshoz
        $positions = Position::all();
        return view('employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, User $employee)
    {
        Log::debug('Update called for employee: ' . $employee->id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'phone_number' => 'required|string|max:15',
            'card_number' => 'required|string|size:16|regex:/^[0-9a-zA-Z]+$/',
            'position_id' => 'required|exists:positions,id',
        ]);

        // Frissítjük a dolgozó adatait
        $employee->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'card_number' => $validated['card_number'],
            'position_id' => $validated['position_id'],
        ]);

        return redirect()->route('employees.index')->with('success', 'Dolgozó adatai sikeresen frissítve.');
    }

    // Törlés metódus
    public function destroy(User $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'A dolgozó törlésre került.');
    }

    // Dolgozó belépéseinek története
    public function showEntries(User $user)
    {
        $entries = $user->userRoomEntries()->orderBy('created_at', 'desc')->paginate(10);

        return view('user.entries', compact('entries', 'user'));
    }
}
