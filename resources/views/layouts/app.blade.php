<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rangkita - Rangkai Kebutuhan Digitalmu')</title>

    <meta name="description" content="@yield('meta_description', 'Rangkita adalah platform undangan digital online, soal latihan ujian, produk digital, dan artikel SEO. Rangkai kebutuhan digitalmu dalam satu tempat.')">
    <meta name="keywords" content="@yield('meta_keywords', 'undangan digital, undangan online, soal latihan ujian, produk digital, Rangkita')">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Rangkita">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Rangkita">
    <meta property="og:title" content="@yield('title', 'Rangkita')">
    <meta property="og:description" content="@yield('meta_description', 'Rangkai kebutuhan digitalmu dalam satu tempat.')">
    <meta property="og:url" content="{{ url()->current() }}">

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
