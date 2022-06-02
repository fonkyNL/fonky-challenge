# fonky-challenge
Mijn goal voor deze challange is om de data uit het csv bestand automatisch te importeren in de database en pie charts te maken voor de producten en kopers.

De pie charts zouden moeten laten zien welke producten het meest populair zijn en wie de grootste kopers zijn.

## Setup
Zet hetvolgende in `.env`:
```
APP_NAME=Fonky-challange
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fonky
DB_USERNAME=root
DB_PASSWORD=
```
Vervang `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` en `DB_PASSWORD` met inloggegevens voor een database.

Installeer dependencies:
```
composer install
```

Genereer `APP_KEY`:
```
php artisan key:generate
```

Maak benodigde tabellen aan:
```
php artisan migrate
```

Voer hetvolgende commando uit om orders.csv te importeren:
```
php artisan orders:import orders.csv
```

Start de webserver met:
```
php artisan serve
```
Of zorg er voor dat er een virtual host in apache word aangemaakt die wijst naar `/public`.

## Gebruik
Op de hoofdpagina van de website staat een lijst met alle orders. Onder het kopje producten staat een pie chart voor het aantal verkochte producten. Onder het kopje kopers staat een pie chart voor het aantal geplaatste orders door een koper.
