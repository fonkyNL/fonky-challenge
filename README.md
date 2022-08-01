**Setup**

#### Requirements
- PHP 8.0+ (with ext-gd)
- Node 14+
- Docker

### Setup
- Copy `.env.example`
```bash
cp .env.example .env
```

#### Install composer dependencies

If you do not have a vendor folder yet run:
```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v $(pwd):/var/www/html \
  -w /var/www/html \
  laravelsail/php81-composer:latest \
  composer install --ignore-platform-reqs
```
if you do you can start Sail with:
```bash
./vendor/bin/sail up -d
```

#### Using sail
You can execute Sail by executing the following command:

`./vendor/bin/sail`

If you do not want to type the entire command every single time, you can create an alias.

Add the following to your `.bashrc` or `.bash_aliases`

`alias sail='./vendor/bin/sail'`

then refresh your terminal. You can now use the sail alias by going to 
your project root and executing 

`sail up -d`

If you do not have the image specified in `docker-compose.yml` locally installed, it will build the image 
for you and store it under the specified name (in this instance `sail-8.1/app`)
You can see your images by running: `docker images`
```yml
services:
laravel.test:
    ...
    image: sail-8.1/app
```

If you already have an image with `sail-8.1/app` and tag `latest` and wish to not override it,
you can simply change the name of the image in the docker-compose.yml file. 
#### Install node dependencies
```bash
sail npm ci
```

#### Build node assets
```bash
sail npm run dev
```
> **Note** <br>
> If you are having problems with your js/css files not being able to load
> try removing the `server` key in its entirety from `vite.config.js`

#### Generate app key
```bash
sail php artisan key:generate
```

#### Run install command
```bash
sail php artisan challenge:install
```
This will refresh your database, run your migrations, ask you for a default user and import the orders.

#### Load up the site!

Visit your website on [localhost](http://localhost)
and login with the user you just created!

The challenge is accessible on [/customers](http://localhost/customers) or through the navigation by clicking on "Customers" on the top of the navigation bar.

#### Extra data
You can add additional data by running the database seeder:
```bash
sail php artisan db:seed
```

#### Run tests
You can run the tests with:
```bash
sail php artisan test
```

You can run PHPStan with:
```bash
./vendor/bin/phpstan analyse
```

