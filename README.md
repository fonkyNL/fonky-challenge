# Fonky Dashboard

## Running

To quickly bootstrap the application, run the following command:

```
make preview
```

Then, head to http://localhost

If orders haven't been imported to the database, execute the following command:

```
make import-orders
# or vendor/bin/sail artisan order:import orders.csv
```

## Tools Used

1. [Laravel 10](https://laravel.com)
2. [Vue 3](https://vuejs.org/)
3. [Tailwind](https://tailwindcss.com/)
4. [Headless UI](https://headlessui.com/)
5. [Tanstack Query](https://tanstack.com/query/latest/docs/vue/installation)
6. [Iconify](https://iconify.design/)
