#### Overview
This repo is seprated in 2 projects: **server (laravel)** and the **client (vue)**. 

### Requirement
I didnt had the time to create a docker container but there is not much that you need.
- PHP 8+ (I'm using 8.1.5)
- Yarn 1.22+ (I'm using 1.22.18)

### Installation

##### Server
1. Go to the server folder
2. Open **.env.example** and change DB_DATABASE to your database name (default name is **fonky**).
3. Run `composer install`
4. Run `cp .env.example .env`
5. Run `composer install`
6. Run `php artisan fonky:install`
7. Serve the application `php artisan serve`

##### Client
1. Open new terminal tab or window.
2. Go to the client folder
3. Open **.env.example** and change API_URL **if needed** (default http://localhost:8000). You can check the api url in the **server** terminal tab/window that you just opened.
4. Run `cp .env.example .env`
5. Run `yarn`
6. Run `yarn dev`


#### Visit the dashboard
The dashboard is now available on http://localhost:3000 if this port is already been used check the **client** terminal tab/window what the url is.


#### Notes

##### Server
- Almost all code can be found in app/Services/Fonky
- Order seeder can be found in app/database/seeders this should already be installed while running `php artisan fonky:install`

##### Client
- Build with Tailwind and Nuxtjs