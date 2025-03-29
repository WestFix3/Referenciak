<x-app-layout>
<x-slot name="title">Dolgozók</x-slot>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Dolgozók listája</h1>

        <!-- Új dolgozó létrehozása gomb (csak adminoknak) -->
        @if(auth()->user()->admin)
            <a href="{{ route('employees.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Új dolgozó létrehozása</a>
        @endif

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Név</th>
                    <th class="px-4 py-2 border-b">Munkakör</th>
                    <th class="px-4 py-2 border-b">Telefonszám</th>
                    @if(auth()->user()->admin)
                        <th class="px-4 py-2 border-b">Műveletek</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $employee->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $employee->position->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border-b">{{ $employee->phone_number }}</td>
                        @if(auth()->user()->admin)
                            <td class="px-4 py-2 border-b">
                                <!-- Admin gombok -->
                                <a href="{{ route('employees.edit', $employee->id) }}" class="text-blue-500 hover:underline">Szerkesztés</a>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Biztosan törölni szeretnéd?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-2">Törlés</button>
                                </form>
                                <a href="{{ route('entries.index', ['user' => $employee->id]) }}" class="text-green-500 hover:underline ml-2">Belépések</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
