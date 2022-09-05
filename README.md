#### Overview
This repo is separated in 2 projects: **server (laravel)** and the **client (vue)**. 

### Installation

##### Server
1. Go to the server folder
2. Run `cp .env.example .env`
3. Open **.env** and change `SERVER_PORT` and `MYSQL_PORT` to availale ports of **your local machine** if needed
4. Run `docker-compose -f docker-compose.yml up -d`
5. Run `docker exec -it fonky-server bash`
6. Run `composer install`
7. Run `php artisan fonky:install`

##### Client
1. Go to the client folder
2. Run `cp .env.example .env`
3. Open **.env** and change `SERVER_PORT` and `CLIENT_PORT` to available ports of **your local machine**. (server port should be the same as `SERVER_PORT` from the server .env).
4. Run `docker-compose -f docker-compose.yml up -d`

#### Visit the dashboard
The dashboard is now available on http://localhost:[CLIENT_PORT]. example: http://localhost:3000

#### Notes
- Tested the docker containers on macOS Monterey and macOS Catalina

##### Server
- Almost all code can be found in app/Services/Fonky
- Order seeder can be found in app/database/seeders this should already be installed while running `php artisan fonky:install`

##### Client
- Build with Tailwind and Nuxtjs