@extends('layouts.master')

<div class="container">
    @if(isset($order))         
        <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="get">
    @else
        <form action="{{ route('orders.store') }}" method="get">
    @endif
        Koper <input type="text" id="Koper" name="Koper" value="{{isset($order)? $order->koper : ''}}">  <br>
        Product <input type="text" id="Product" name="product" value="{{isset($order)? $order->product : ''}}"> <br>
        Vestiging <input type="text" id="Vestiging" name="vestiging" value="{{isset($order)? $order->vestiging : ''}}"> <br>
        Verkoper <input type="text" id="Verkoper" name="verkoper" value="{{isset($order)? $order->verkoper : ''}}"> <br>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
