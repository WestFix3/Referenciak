<x-guest-layout>
    <x-slot name="title">{{ $user->name }} Belépési Története</x-slot>

    <h1>{{ $user->name }} belépési kísérletei</h1>

    @if ($entries->isEmpty())
        <p>Nincs belépési történet.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Dátum</th>
                    <th>Szoba neve</th>
                    <th>Sikeres?</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $entry->room->name }}</td>
                        <td>{{ $entry->successful ? 'Sikeres' : 'Sikertelen' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Lapozás -->
        {{ $entries->links() }}
    @endif
</x-guest-layout>
