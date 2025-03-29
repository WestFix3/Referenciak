<x-app-layout>
    <x-slot name="title">Munkakör szerkesztése</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Munkakör szerkesztése</h1>

        <form action="{{ route('positions.update', $position) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Munkakör neve</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded"
                       value="{{ old('name', $position->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Frissítés</button>
        </form>
    </div>
</x-app-layout>
