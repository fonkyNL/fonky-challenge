SHELL=/bin/bash

project-build:
	@echo "Copying .env file..."
	@cp -n .env.example .env
	@echo "Building application..."
	@vendor/bin/sail up -d
	@vendor/bin/sail composer install
	@vendor/bin/sail artisan key:generate --ansi
	@vendor/bin/sail artisan migrate

assets-build:
	@echo "Building assets..."
	@vendor/bin/sail npm install
	@vendor/bin/sail npm run build

import-orders:
	@echo "Importing orders..."
	@vendor/bin/sail artisan order:import orders.csv

preview: project-build assets-build import-orders
