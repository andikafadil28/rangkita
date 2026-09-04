<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Preview Template {{ $template->name }} - Rangkita</title>
    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
    <script src="{{ asset('js/wedding-invitation.js') }}" defer></script>
</head>
<body class="wedding-preview-body {{ $template->theme_class ?? 'theme-default' }}">
    @include('pages.partials.wedding-invitation', [
        'backUrl' => route('weddings.index').'#template',
        'wishEnabled' => false,
    ])
</body>
</html>
