<x-app-layout>
    <x-slot name="title">Új munkakör létrehozása</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Új munkakör létrehozása</h1>
        <form action="{{ route('positions.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Munkakör neve</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded" value="{{ old('name') }}" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Létrehozás</button>
        </form>
    </div>
</x-app-layout>
