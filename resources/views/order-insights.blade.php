<html>
<head>

</head>
<body>
    @foreach ($orders as $order)
        @foreach ($order->toArray() as $column => $aField)
            <div>{{ $column }}: {{ $aField }}</div>
        @endforeach
    @endforeach
</body>
</html>
