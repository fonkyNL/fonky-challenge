
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />  
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>


<div class="container">
	<nav class="navbar navbar-inverse">
		<ul class="nav navbar-nav">
			<li><a class="btn btn-small btn-primary" href="{{ url()->previous() }}">back</a></li>
		</ul>
	</nav>
    @if(isset($order))         
        <form action="{{ route('orders.update', ['order' => $order->id]) }}" method="put">
    @else
        <form action="{{ route('orders.create') }}" method="POST">
    @endif
        Koper <input type="text" id="Koper" name="Koper" value="{{isset($order)? $order->koper : ''}}">  <br>
        Product <input type="text" id="Product" name="product" value="{{isset($order)? $order->product : ''}}"> <br>
        Vestiging <input type="text" id="Vestiging" name="vestiging" value="{{isset($order)? $order->vestiging : ''}}"> <br>
        Verkoper <input type="text" id="Verkoper" name="verkoper" value="{{isset($order)? $order->verkoper : ''}}"> <br>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
