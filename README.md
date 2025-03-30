# Referenciak

## Multiplayer Bomberman
Projekt Áttekintés
A projekt célja egy többjátékos, kompetitív Bomberman játék fejlesztése Go nyelven, amelyet két vagy több játékos játszik. A cél, hogy az egyik játékos életben maradjon, a többivel szemben.

Játék Leírása
A játék egy 2D-s pályán zajlik, ahol a játékosok bombákat helyeznek el, hogy elpusztítsák a dobozokat, szörnyeket és egymást. A játék akkor ér véget, ha egy játékos marad csak életben.

Főbb Jellemzők
Falak: Felrobbanthatatlan elemek, amelyeken nem lehet áthaladni.
Játékosok: Bomberman karakterek, amelyeket a billentyűzettel lehet irányítani.
Bombák: Rövid idő után felrobbannak, és minden irányban hatnak.
Dobozok: Felrobbantható elemek, amelyek bónuszokat rejthetnek.
Szörnyek: A pályán bolyonganak és megölik a játékosokat, ha hozzájuk érnek.

Bónuszok
További Bombák: Növeli a lehelyezhető bombák számát.
Robbanás Hatótávja: Növeli a bombák robbanási sugarát.
Detonátor: Lehetővé teszi a bombák kézi robbantását.
Görkorcsolya: Növeli a játékos mozgási sebességét.
Sérthetetlenség: Ideiglenesen sérthetetlenné teszi a játékost.
Szellem: Lehetővé teszi a falakon, dobozokon és bombákon való áthaladást.

Szörnyek
A játékban különböző szörnyek lesznek, amelyek eltérő sebességgel és viselkedéssel mozognak. Legalább négyféle szörny szükséges:
Alap Szörny: Egyszerű mozgás.
Átjáró Szörny: Áthalad a falakon és dobozokon, de lassabb.
Követő Szörny: A legközelebbi játékost követi, gyorsabb.
Elágazó Szörny: Irányt vált elágazásoknál, néha hibázik.

Játék Vége
A játék rövid ideig folytatódik a játékosok haláláig, hogy eldöntse a győztest. Ha mindkét játékos meghal, a játék döntetlennel zárul.

Letöltés: bomberman

## Laravel
Beléptető Rendszer Projekt
Feladat: Készíts egy adminisztrációs és felügyeleti rendszert egy szervezet beléptető rendszeréhez. A feladatot szabadon alakíthatod, amíg a követelményeket teljesíted.

Követelmények
Adatbázis és Modellek: Hozz létre adatbázis táblákat és modelleket (User, Position, Room, UserRoomEntry).
Seeder: Készíts egy seedert, amely feltölti az adatbázist konzisztens adatokkal.
Főoldal: Jeleníts meg egy rövid ismertetőt és statisztikákat.
Dolgozók: Listázás, létrehozás, módosítás, törlés, belépések története.
Munkakörök: Listázás, létrehozás, módosítás, törlés, dolgozók listája.
Szobák: Listázás, létrehozás, módosítás, törlés, belépések története.
Belépés Szimuláció: Szimuláld a belépéseket és jelenítsd meg a jogosultságokat.

Általános Elvárások
Laravel Validáció: Minden esetben kötelező a Laravel validációs lehetőségeit alkalmazni. Kliensoldali validáció nem elfogadható.
Állapottartó Űrlapok: Hibák esetén a felhasználó által megadott adatokat vissza kell tölteni az űrlapba, és pontos hibaüzeneteket kell megjeleníteni.
Szerkesztés: Az űrlapokat ki kell tölteni a meglévő adatokkal.
Hibakezelés: Minden hibát érthetően kell jelezni a felhasználónak. A kód lefagyása vagy összeomlása pontlevonást eredményezhet.
Jogosultságkezelés: Nem elegendő csak a frontend végpontokat levédeni, a műveletet végző végpontnál is szükséges az ellenőrzés.
Frontend Technológia: Szabadon választható volt, leírás alapján nem érdemes túlbonyolítani, viszont törekedtem a funkcionalitásra, használhatóságra és a szépségre.


Letöltés: laravel
