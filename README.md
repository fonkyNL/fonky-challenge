# Fonky Client Dashboard

This repository contains a comprehensive dashboard for displaying and managing orders for a Fonky client. The dashboard incorporates various features that enable users to efficiently interact with the orders and gain valuable insights into the business.

## Key Features

- **Order Visualization:** The dashboard provides an intuitive interface to view and analyze the orders, allowing users to easily navigate through the data and gain a comprehensive understanding of the order patterns.

- **Order Manipulation:** Users have the ability to manipulate the orders within the dashboard. This includes functionalities such as sorting, filtering, and searching for specific orders based on various criteria, enhancing the ease of order management.

- **Business Highlights:** The dashboard also presents key highlights of the business, providing users with valuable insights and metrics such as top-selling products, revenue trends, and customer behavior analysis. These highlights facilitate data-driven decision-making and help drive business growth.

## Prerequisites

Before running this project, ensure that you have the following prerequisites installed:
- Laravel 10
- PHP 8
- Database (preferably MySQL server)
- Composer
- Web Server (documentation provided for Apache)
- Node.js and npm

## Installation
1. Install php by following the instructions provided [here](https://www.geeksforgeeks.org/how-to-install-php-on-linux/)
2. Database to setup the database followthe instruction in the link [here](https://laravel.com/docs/10.x/database)
3. Install Composer by following the instructions provided [here](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos).
4. Install your favorate web server if you wish to work with apache then you can install it by running this command: sudo apt install apache2
3. Install Node.js and npm by following the instructions provided [here](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm).

## Configuration & Pupulate Database

1. Set up your database configuration by editing the `.env` file:  
DB_CONNECTION={{mysql}}  
DB_DATABASE=/path/to/database  
DB_USERNAME={{username}}  
DB_PASSWORD={{password}}  
DB_PORT={{port}}  
  Replace the place holders with the appropreate values for your case

2. Now that your database connection is set, it is time to create your first database table by running:  
  > php artian migrate
This will run the createOrdersTable migration which will create the Orders table in your database

3. Once your database table is created, lets get ig pupulated. run the following command to run the seeders:  
>php artisan db:seed --class=OrdersTableSeeder
This seeder will copy the data from `orders.csv` located in the project's root and populate the `Orders` table. 
Note that some column changes were made for better structure and visualization, while preserving the core information of the data.

## Installing composer packages
Now you need to install the required packages by composer run the following command: 
>composer install
>composer update

## Running the application
Now that everything is set up you can navigate to your dash-board laravel project, and run 
>php artisan serve
The server will start, and you can access the application by visiting the displayed host (e.g., http://127.0.0.1:8000) in your favorite browser.

## install dependancies and running the resources (js and css)
1. nstall the necessary packages specified in package.json by running the following commands:
>npm install
>npm run dev
This will install the required JavaScript and CSS packages and compile them for use in the application.

2. And finally Run the following command to continuously watch for changes to JavaScript and CSS files:
>npm run watch
This script will migrate the JavaScript and CSS files to the public folder, making them usable by your application.


## App Tour
Take yourself on a tour through the dashboard. It is pretty much self-explanatory, with only a few views to navigate.

Enjoy exploring and managing the orders for the Fonky client!


