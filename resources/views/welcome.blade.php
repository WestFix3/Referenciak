<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Főoldal</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Üdvözöljük a Cég Kártyaolvasós Beléptető Rendszerében</h1>
        
     
<p>
            Ez a rendszer lehetővé teszi a dolgozók számára, hogy a megfelelő jogosultságokkal rendelkező helyiségekbe léphessenek be kártyájuk segítségével.
            A rendszer nyilvántartja az összes belépést, és adminisztrációs felületet biztosít a jogosultságok kezelésére.
        
            Ez a rendszer lehetővé teszi a dolgozók számára, hogy a megfelelő jogosultságokkal rendelkező helyiségekbe léphessenek be kártyájuk segítségével.
            A rendszer nyilvántartja az összes bel
</p>

        <h2>Statisztikák</h2>
        <ul>
            <li>Létrehozott szobák száma: {{ $roomCount }}</li>
            <li>Kezelt dolgozók száma: {{ $userCount }}</li>
        </ul>
    </div>
</body>
</html>