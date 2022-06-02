<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fonky</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- I should create a CSS file for this... -->
        <style>
            .pagination {
                justify-content: center;
            }
        </style>
    </head>
    <body>
        @include('includes.nav')
        <div class="container">
            <table class="table">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Koper</th>
                    <th scope="col">Datum / tijd</th>
                    <th scope="col">Product</th>
                    <th scope="col">Vestiging / verkoper</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->buyer->name }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->product->name }}</td>
                        <td>{{ $order->establishment->name }} / {{ $order->seller->name }}</td>
                    </tr>
                @endforeach
            </table>
            <div class="text--center">
                {{ $orders->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </body>
</html>
