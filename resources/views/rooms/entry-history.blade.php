<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Belépési kísérletek története - {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left">Dátum</th>
                                <th class="px-4 py-2 text-left">Felhasználó</th>
                                <th class="px-4 py-2 text-left">Telefonszám</th>
                                <th class="px-4 py-2 text-left">Munkakör</th>
                                <th class="px-4 py-2 text-left">Sikeres</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $entry)
                                <tr>
                                    <td class="px-4 py-2">{{ $entry->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td class="px-4 py-2">{{ $entry->user->name }}</td>
                                    <td class="px-4 py-2">{{ $entry->user->phone_number }}</td>
                                    <td class="px-4 py-2">{{ $entry->user->position->name }}</td>
                                    <td class="px-4 py-2">
                                        @if ($entry->successful)
                                            <span class="text-green-500">Sikeres</span>
                                        @else
                                            <span class="text-red-500">Sikertelen</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Lapozó -->
                    <div class="mt-4">
                        {{ $entries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
