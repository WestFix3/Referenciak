<x-app-layout>
    <x-slot name="title">Szoba létrehozása</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Új Szoba Létrehozása</h1>

        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Szoba neve</label>
                <input type="text" name="name" id="name" class="w-full mt-1 border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Leírás</label>
                <textarea name="description" id="description" class="w-full mt-1 border-gray-300 rounded-md"></textarea>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Kép</label>
                <input type="file" name="image" id="image" class="w-full mt-1 border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Munkakörök</label>
                <select name="positions[]" id="positions" class="w-full mt-1 border-gray-300 rounded-md" multiple required>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Szoba létrehozása</button>
            </div>
        </form>
    </div>
</x-app-layout>
