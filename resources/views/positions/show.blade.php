<x-app-layout>
    <x-slot name="title">{{ $position->name }} munkakör dolgozói</x-slot>
    
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">{{ $position->name }} munkakör dolgozói</h1>

        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Név</th>
                    <th class="px-4 py-2 border-b">Telefonszám</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                        <td class="px-4 py-2 border-b">{{ $user->phone_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>