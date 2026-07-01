<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rangkita')</title>

    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
</head>

<body>

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <p>© 2026 Rangkita Digital. Rangkai kebutuhan digitalmu dalam satu tempat.</p>
    </footer>

</body>

</html>
