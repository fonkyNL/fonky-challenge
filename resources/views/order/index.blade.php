<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>Funky Dashboard</title>
  </head>
  <body>
   <div class="container my-5">
       <h1 class="fs-5 fw-bold text-center">Order import & export</h1>
       <div class="row">
           <div class="d-flex my-2">
               <a href="" class="btn btn-primary me-1">Export Data</a>
               <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Data
                </button>
           </div>
           @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
           @endif
           @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Koper</th>
                    <th scope="col">Product</th>
                    <th scope="col">Vestiging</th>
                    <th scope="col">Verkoper</th>
                    <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_nummer }}</td>
                            <td>{{ $order->koper }}</td>
                            <td>{{ $order->product }}</td>
                            <td>{{ $order->vestiging }}</td>
                            <td>{{ $order->verkoper }}</td>
                            <td>{{ date('d-m-Y', strtotime($order->datum_tijd)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $orders->render() }}
            </div>
       </div>
   </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('orders') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="file" name="order_file" class="form-control">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    {{-- Script --}}
    <script src="{{ asset('js/app.js') }}" defer></script>

  </body>
</html>