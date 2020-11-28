
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DSJ API</title>
    </head>
    <body >

        <h1>DSJ API, resources/views/welcome.blade.php</h1>
        <ul>
            <li><a href="{{ url('/tournaments') }}">Tournaments</a></li>
        </ul>

        <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>

    </body>
</html>
