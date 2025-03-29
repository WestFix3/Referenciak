<x-app-layout>
    <x-slot name="title">Szobák</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Szobák</h1>

        @if (auth()->user()->admin)
            <a href="{{ route('rooms.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Új szoba hozzáadása</a>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Szoba neve</th>
                    <th class="px-4 py-2 border-b">Munkakörök</th>
                    @if (auth()->user()->admin)
                        <th class="px-4 py-2 border-b">Műveletek</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $room->name }}</td>
                        <td class="px-4 py-2 border-b">
                            @foreach ($room->positions as $position)
                                {{ $position->name }}@if (!$loop->last), @endif
                            @endforeach
                        </td>
                        @if (auth()->user()->admin)
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('rooms.edit', $room) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Szerkesztés</a>
                                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Biztosan törölni szeretnéd ezt a szobát?')" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 ml-2">Törlés</button>
                                </form>
                                <a href="{{ route('rooms.entries', $room) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 ml-2">Belépések</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
