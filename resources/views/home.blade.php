<x-app-layout>
    <x-slot name="title">Fő oldal</x-slot>
    <div class="container">
        <h1>Üdvözöljük a Cég Beléptető Rendszerében</h1>

        <p>
            Ez a rendszer lehetővé teszi a dolgozók számára, hogy a megfelelő jogosultságokkal rendelkező helyiségekbe léphessenek be kártyájuk segítségével.
            A rendszer nyilvántartja az összes belépést, és adminisztrációs felületet biztosít a jogosultságok kezelésére.
        </p>

        <h2>Statisztikák</h2>
        <ul>
            <li>Létrehozott szobák száma: {{ $roomCount }}</li>
            <li>Kezelt dolgozók száma: {{ $userCount }}</li>
        </ul>
    </div>
</x-app-layout>
