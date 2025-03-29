<x-app-layout>
    <x-slot name="title">Munkakörök</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Munkakörök</h1>

        {{-- Csak adminok láthatják az új munkakör hozzáadása gombot --}}
        @if (auth()->user()->admin)
            <a href="{{ route('positions.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Új munkakör hozzáadása</a>
        @endif

        <div class="positions-table">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Név</th>
                        <th class="px-4 py-2 border-b">Dolgozók száma</th>
                        <th class="px-4 py-2 border-b">Szobák</th>
                        <th class="px-4 py-2 border-b">Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($positions as $position)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $position->name }}</td>
                            <td class="px-4 py-2 border-b">{{ $position->users->count() }}</td>
                            <td class="px-4 py-2 border-b">
                                @foreach ($position->rooms as $room)
                                    {{ $room->name }}
                                @endforeach
                            </td>
                            <td class="px-4 py-2 border-b">
                                {{-- Csak adminok láthatják a szerkesztés és törlés gombokat --}}
                                @if (auth()->user()->admin)
                                    <a href="{{ route('positions.edit', $position) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Szerkesztés</a>
                                    <form action="{{ route('positions.destroy', $position) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 ml-2">Törlés</button>
                                    </form>
                                @endif

                                {{-- A dolgozók listája mindenki számára elérhető --}}
                                <a href="{{ route('positions.show', $position) }}" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 ml-2">Dolgozók</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
