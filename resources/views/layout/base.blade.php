
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DSJ API - @yield('title')</title>
    </head>
    <body>

        @section('header')
            @include('layout.header')
        @show

        @section('content')
            <p>DSJ API content placeholder</p>
        @show


        @section('footer')
            @include('layout.footer')
        @show
       

    </body>
</html>
