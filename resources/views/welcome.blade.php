<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

        <title>Bramming</title>
        <style>
            html, body {
                height: 100%;
            }
            .container {
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="text-center">
                <h1>Velkommen til Bramming Efterskole</h1>
                <p>Her kan du finde information om skolen og se hvilke elever der går på skolen.</p>
                @if (Auth::check())
                    <a href="{{ route('index') }}" class="btn btn-primary">Se elever</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log ind</a>
                @endif
            </div>
        </div>
    </body>
</html>
