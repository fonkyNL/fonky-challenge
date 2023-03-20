SHELL=/bin/bash

preview:
	@echo "Copying .env file..."
	@cp -n .env.example .env
	@echo "Building application..."
	@vendor/bin/sail up -d
	@vendor/bin/sail composer install
	@vendor/bin/sail artisan key:generate --ansi
	@vendor/bin/sail artisan migrate
	@echo "Building assets..."
	@vendor/bin/sail npm install
	@vendor/bin/sail npm run build
	@echo "Importing orders..."
	@vendor/bin/sail artisan order:import orders.csv
