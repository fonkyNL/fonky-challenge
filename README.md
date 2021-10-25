Sollicitant: Xander
Datum      : 2021-10-25


Hieronder worden de instructies beschreven hoe de fonky challenge opdracht werkend te krijgen.



-- Installeer de bestanden van de fonky challenge in ergens met git clone.


-- Zet onderstaande regels in een .sql-bestand met de naam create_database.sql:
CREATE DATABASE fonky;
CREATE USER 'fonky'@'localhost' IDENTIFIED BY 'ik43j2iJb9i38H&*@1iJqoxGS';
GRANT ALL PRIVILEGES ON fonky.* TO 'fonky'@'localhost';


-- Voer het bestand als volgt uit in de terminal Ubuntu:
mysql -uroot -p  <  create_database.sql


-- Voer het volgende commando uit in de terminal van Ubuntu om de tabelstructuren aan te maken in MySQL:
php artisan migrate:fresh


-- Stop het bestand orders.csv in de database:
php artisan db:seed --class=OrdersSeeder


-- Start de web server van Laravel:
php artisan serve


