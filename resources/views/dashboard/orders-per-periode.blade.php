@extends('dashboard.main-layout')

@section('content')


    @if (count($orders) === 0)
        Er zijn geen records.
    @else
        <table>
            <tr>
                <th>Aantal orders</th>
                <th>Maand</th>
            </tr>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->aantalOrders }}</td>
                    <td>{{ $order->maand }}</td>
                </tr>
            @endforeach
        </table>
    @endif

@endsection