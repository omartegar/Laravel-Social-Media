<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name='csrf-token' content="{{ csrf_token() }}">
    <title>Welcome</title>
    @vite(['resources/css/app.css'])
    @yield('styles')
</head>

<body>
    <h1 class='static_title_message'>Laravel - Social Media Application by Omar</h1>

    <main>
        @yield('content')
    </main>
</body>

</html>
