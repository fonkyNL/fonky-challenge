@extends('dashboard.main-layout')

@section('content')

    @if (count($orders) === 0)
            Er zijn geen records.
        @else
            <table>
                <tr>
                    <th>Ordernummer</th>
                    <th>Koper</th>
                    <th>Orderdatum</th>
                    <th>ProductId</th>
                    <th>Vestiging</th>
                    <th>Verkoper</th>
                </tr>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->orderId }}</td>
                        <td>{{ $order->koper }}</td>
                        <td>{{ $order->orderdatum }}</td>
                        <td>{{ $order->productId }}</td>
                        <td>{{ $order->vestiging }}</td>
                        <td>{{ $order->verkoper }}</td>
                    </tr>
                @endforeach
            </table>
    @endif

@endsection