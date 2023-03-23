<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/all.css">
    <title>{{ $title ?? 'Google Calendar' }}</title>
    @stack('css')
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12" id="app">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/js/fontawesome.js"></script>
    @stack('js')
</body>

</html>
