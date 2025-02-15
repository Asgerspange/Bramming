<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bramming Efterskole</title>
    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body>
    @if (Auth::check())
        @if (Auth::user()->is_teacher)
            <a href="{{ route('admin-users') }}">Admin</a>
        @endif
    @endif
    @inertia
</body>
</html>