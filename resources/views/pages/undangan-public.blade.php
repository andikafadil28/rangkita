<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Undangan pernikahan {{ $wedding->groom_short_name }} dan {{ $wedding->bride_short_name }}.">
    @if ($wedding->status === 'draft')
        <meta name="robots" content="noindex, nofollow">
    @endif
    <title>{{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}</title>
    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
    <script src="{{ asset('js/wedding-invitation.js') }}" defer></script>
</head>
<body class="wedding-preview-body {{ $template->theme_class ?? 'theme-default' }}">
    @if ($wedding->status === 'draft')
        <div class="draft-preview-banner">Preview admin: undangan ini masih draft.</div>
    @endif

    @include('pages.partials.wedding-invitation', [
        'backUrl' => null,
        'wishEnabled' => $wedding->status === 'published',
    ])
</body>
</html>
