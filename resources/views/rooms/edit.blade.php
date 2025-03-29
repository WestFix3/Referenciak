<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Szoba szerkesztése
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Szoba neve -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Szoba neve</label>
                            <input type="text" name="name" value="{{ old('name', $room->name) }}" class="w-full mt-1 border-gray-300 rounded-md" required>
                        </div>

                        <!-- Szoba leírása -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Leírás</label>
                            <textarea name="description" class="w-full mt-1 border-gray-300 rounded-md">{{ old('description', $room->description) }}</textarea>
                        </div>

                        <!-- Szoba képe -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Szoba képe</label>
                            @if($room->image)
                                <img src="{{ asset('storage/' . $room->image) }}" alt="Szoba kép" class="mb-4 w-32 h-32 object-cover">
                            @endif
                            <input type="file" name="image" class="w-full mt-1 border-gray-300 rounded-md">
                        </div>

                        <!-- Munkakörök -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Munkakörök</label>
                            <select name="positions[]" id="positions" class="w-full mt-1 border-gray-300 rounded-md" multiple required>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}" 
                                        @if($room->positions->pluck('id')->contains($position->id)) selected @endif>
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Submit gomb -->
                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Szoba módosítása</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
