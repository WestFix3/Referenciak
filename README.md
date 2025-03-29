<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Referenciak

## Multiplayer Bomberman Projekt
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

Letöltés: ninjago_fix.zip

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


Letöltés: laravel.zip
>>>>>>> origin/laravel
