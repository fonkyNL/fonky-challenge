**Setup**

#### Requirements
- PHP 8.0+ (with ext-gd)
- Node 14+

### Setup 
- Copy `.env.example`
```bash
cp .env.example .env
```
> **Note** <br>
> If you are using docker-compose (or sail) you should update the following .env variables
> ```env
> DB_HOST=mysql
> DB_USERNAME=sail
> DB_PASSWORD=password
> REDIS_HOST=redis
> MAIL_HOST=mailhog
>```


#### Install composer dependencies
```bash
  composer install
```
> **Note** <br>
> If you are using docker (or sail) you can run the following command
> ```bash
>  docker run --rm \
>    -u "$(id -u):$(id -g)" \
>    -v $(pwd):/var/www/html \
>    -w /var/www/html \
>    laravelsail/php81-composer:latest \
>    composer install --ignore-platform-reqs
>```

#### Install node dependencies
```bash
npm ci
```
> **Note** <br>
> If you are using sail, run each command with `sail` prefixed
> eg: in the case above it should be:
> ```bash
> sail npm ci
>```

#### Build node assets
```bash
npm run dev
```
> **Note** <br>
> If you are having problems with your js/css files not being able to load
> try removing the `server` key in its entirety from `vite.config.js`

#### Generate app key
```bash
php artisan key:generate
```

#### Run install command
```bash
php artisan challenge:install
```
This will refresh your database, run your migrations, ask you for a default user and import the orders.

#### Load up the site!

Visit your website on [localhost](http://localhost)
and login with the user you just created!

The challenge is accessible on [/customers](http://localhost/customers) or through the navigation by clicking on "Customers" on the top of the navigation bar.

#### Extra data
You can add additional data by running the database seeder:
```bash
php artisan db:seed
```

#### Run tests
You can run the tests with:
```bash
php artisan test
```
