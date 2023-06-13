<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" />  
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<nav class="navbar navbar-inverse" style="display: flex; justify-content: center; align-items: flex-start;">
    <ul class="nav navbar-nav">
        <li>
            <a class="btn btn-small btn-primary" href="{{ url()->previous() }}">back</a>
        </li>
    </ul>
</nav>