#Laravel App with Docker
This repository contains a Laravel application that can be easily launched using Docker. It provides a simple setup for running your Laravel app in a containerized environment.

#Prerequisites
Make sure you have the following software installed on your machine:

- Docker
- Docker Compose
#Getting Started
Follow the steps below to get the Laravel app up and running:

1. Clone this repository to your local machine: `git clone https://github.com/ToniMijatovic/fonky-challenge`
2. Copy the .env.example file to .env: `cp .env.example .env` 
3. Build and start the Docker containers: `docker-compose up -d --build`
4. Obtain the container ID, run the following command: `docker ps`
5. Access the container shell by running the following command: `docker exec -it <container_id> bash`
6. Run the database migrations and seed the database: `php artisan migrate --seed`
7. Open your web browser and visit http://localhost:9101 to see the running Laravel app.

Note: No changes are required in the .env file for the database credentials.

# Laravel PHP Project Installation without docker
If installing with Docker for some reason did not work, you can follow these steps to do it on the regular way.

## Prerequisites

Before proceeding with the installation, ensure that you have the following software installed on your machine:

- PHP 8.1 or greater
- Node.js 19
- NPM (Node Package Manager)

## Installation Steps

Follow these steps to install the Laravel PHP project:

1. Clone this repository to your local machine: `git clone https://github.com/ToniMijatovic/fonky-challenge`
2. Navigate to the project directory: `cd fonky-challenge`
3. Install PHP dependencies using Composer: `composer install`
4. Copy the `.env.example` file to `.env`: `cp .env.example .env`
5. Modify the `.env` file with the necessary configuration settings such as database credentials, app URL, etc.
6. Generate the application key: `php artisan key:generate`
7. Run database migrations: `php artisan migrate`
8. Start the development server: `php artisan serve`
9. In a new terminal, go to the project and install JavaScript dependencies using NPM: `npm install`
10. Compile the front-end assets: `npm run dev` (or `npm run production` for production environment)

The Laravel development server will be running at `http://localhost:8000`.

# API Documentation: Get Orders

This documentation provides information on how to use the `api/v1/orders` endpoint to retrieve orders with different
parameters.

## Endpoint

GET /api/v1/orders

## Request Parameters

| Parameter  | Type     | Description                            | Required | Possible Values                    |
|------------|----------|----------------------------------------|----------|------------------------------------|
| supplier   | string   | The supplier of the orders             | Yes      | "seller", "branch"                 |
| type       | string   | The type of summary calculation        | Yes      | "SUM", "AVG", "COUNT"              |
| where      | string   | Additional conditions for the orders    | No       | "Utrecht", "Nijmegen", and so on   |
| dateFrom   | date     | Start date of the order range           | No       |                                    |
| dateTo     | date     | End date of the order range             | No       | Must be after or equal to dateFrom |

## Response

The response will be a JSON object containing an array of order summaries.

Example response:

```json
{
    "data": [
        {
            "supplier": "Nijmegen",
            "amount": 100.00
        },
        {
            "supplier": "Utrecht",
            "amount": 200.00
        }
    ]
}
```

###Retrieve Order Summaries for Seller

GET /api/v1/orders?supplier=seller&type=SUM

Response:

```json
{
    "data": [
        {
            "supplier": "Janet Kuiper",
            "amount": 326
        },
        {
            "supplier": "Susan de Sousa",
            "amount": 267.5
        },
        {
            "supplier": "Mike de Jagt",
            "amount": 253.5
        },
        {
            "supplier": "Corina de Rijke",
            "amount": 229.5
        },
        {
            "supplier": "Helga Winkel",
            "amount": 217
        },
        {
            "supplier": "Alex Oosterhuis",
            "amount": 183.5
        },
        {
            "supplier": "Alida Kuipers",
            "amount": 183.5
        },
        {
            "supplier": "Judith Storm",
            "amount": 175
        },
        {
            "supplier": "Saartje Pleinen",
            "amount": 116
        },
        {
            "supplier": "Tom de Hollander",
            "amount": 114.5
        },
        {
            "supplier": "Alex de Vries",
            "amount": 114
        },
        {
            "supplier": "Charles de Bakker",
            "amount": 112.5
        },
        {
            "supplier": "Rex Wijen",
            "amount": 99
        },
        {
            "supplier": "Esther Oostland",
            "amount": 91.5
        },
        {
            "supplier": "Charles Bakker",
            "amount": 90.5
        },
        {
            "supplier": "Anton de Vlieger",
            "amount": 79
        },
        {
            "supplier": "Anne van Dijk",
            "amount": 71
        },
        {
            "supplier": "Laura Katshuis",
            "amount": 63
        },
        {
            "supplier": "Stan Akkerboom",
            "amount": 47
        },
        {
            "supplier": "Minoes Smits",
            "amount": 40
        },
        {
            "supplier": "Wil ten Wolde",
            "amount": 28
        },
        {
            "supplier": "Max Geluk",
            "amount": 18
        }
    ]
}
```

###Retrieve Order Summaries for Branch Request:

GET /api/v1/orders?supplier=branch&type=SUM

```json
{
    "data": [
        {
            "supplier": "Nijmegen",
            "amount": 837.5
        },
        {
            "supplier": "Utrecht",
            "amount": 650.5
        },
        {
            "supplier": "Rotterdam",
            "amount": 548
        },
        {
            "supplier": "HQ",
            "amount": 496.5
        },
        {
            "supplier": "Eindhoven",
            "amount": 212.5
        },
        {
            "supplier": "Groningen",
            "amount": 174.5
        }
    ]
}

```

###Retrieve Average Order Amount for Branches Request

GET /api/v1/orders?supplier=branch&type=AVG

```json
{
    "data": [
        {
            "supplier": "Eindhoven",
            "amount": 21.25
        },
        {
            "supplier": "HQ",
            "amount": 18.38888888888889
        },
        {
            "supplier": "Utrecht",
            "amount": 12.273584905660377
        },
        {
            "supplier": "Rotterdam",
            "amount": 9.963636363636363
        },
        {
            "supplier": "Groningen",
            "amount": 9.694444444444445
        },
        {
            "supplier": "Nijmegen",
            "amount": 9.626436781609195
        }
    ]
}
```

###Retrieve Average Order Amount for Seller Request

GET /api/v1/orders?supplier=seller&type=AVG

```json
{
    "data": [
        {
            "supplier": "Eindhoven",
            "amount": 21.25
        },
        {
            "supplier": "HQ",
            "amount": 18.38888888888889
        },
        {
            "supplier": "Utrecht",
            "amount": 12.273584905660377
        },
        {
            "supplier": "Rotterdam",
            "amount": 9.963636363636363
        },
        {
            "supplier": "Groningen",
            "amount": 9.694444444444445
        },
        {
            "supplier": "Nijmegen",
            "amount": 9.626436781609195
        }
    ]
}
```

###Retrieve Order Count for Branch Request:

GET /api/v1/orders?supplier=branch&type=COUNT

```json
{
    "data": [
        {
            "supplier": "Nijmegen",
            "amount": 87
        },
        {
            "supplier": "Rotterdam",
            "amount": 55
        },
        {
            "supplier": "Utrecht",
            "amount": 53
        },
        {
            "supplier": "HQ",
            "amount": 27
        },
        {
            "supplier": "Groningen",
            "amount": 18
        },
        {
            "supplier": "Eindhoven",
            "amount": 10
        }
    ]
}
```

###Retrieve Order Count for Sellers Request:

GET /api/v1/orders?supplier=seller&type=COUNT

```json
{
    "data": [
        {
            "supplier": "Mike de Jagt",
            "amount": 24
        },
        {
            "supplier": "Corina de Rijke",
            "amount": 24
        },
        {
            "supplier": "Janet Kuiper",
            "amount": 23
        },
        {
            "supplier": "Alida Kuipers",
            "amount": 20
        },
        {
            "supplier": "Helga Winkel",
            "amount": 16
        },
        {
            "supplier": "Susan de Sousa",
            "amount": 15
        },
        {
            "supplier": "Alex de Vries",
            "amount": 12
        },
        {
            "supplier": "Saartje Pleinen",
            "amount": 11
        },
        {
            "supplier": "Tom de Hollander",
            "amount": 11
        },
        {
            "supplier": "Charles de Bakker",
            "amount": 11
        },
        {
            "supplier": "Judith Storm",
            "amount": 10
        },
        {
            "supplier": "Esther Oostland",
            "amount": 9
        },
        {
            "supplier": "Rex Wijen",
            "amount": 9
        },
        {
            "supplier": "Anton de Vlieger",
            "amount": 9
        },
        {
            "supplier": "Alex Oosterhuis",
            "amount": 9
        },
        {
            "supplier": "Charles Bakker",
            "amount": 8
        },
        {
            "supplier": "Laura Katshuis",
            "amount": 7
        },
        {
            "supplier": "Anne van Dijk",
            "amount": 7
        },
        {
            "supplier": "Stan Akkerboom",
            "amount": 5
        },
        {
            "supplier": "Minoes Smits",
            "amount": 5
        },
        {
            "supplier": "Wil ten Wolde",
            "amount": 3
        },
        {
            "supplier": "Max Geluk",
            "amount": 2
        }
    ]
}
```

By providing the `dateFrom` or `dateTo` parameters you can filter out the results based on the date. Additionally you
can put the `where` parameter in the url aswel, this will filter out the result sets based on the `supplier` parameter
and the `where` parameter.

###Error Handling

In case of invalid requests or errors, the API will respond with appropriate error messages and status codes.

```json
{
    "error": "Validation failed.",
    "messages": {
        "supplier": [
            "The supplier field is required."
        ],
        "type": [
            "The type field is required."
        ]
    }
}
```
