<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $link->og_title }}</title>

    {{-- Meta Tags untuk Preview Link --}}
    <meta property="og:title" content="{{ $link->og_title }}">
    <meta property="og:description" content="{{ $link->og_description }}">
    @if($link->og_image)
        <meta property="og:image" content="{{ Storage::url($link->og_image) }}">
    @endif
    <meta property="og:url" content="{{ url($link->slug) }}">
    <meta property="og:type" content="website">
</head>

<body>
    <p>Sedang mengalihkan ke tujuan...</p>

    {{-- Redirect menggunakan JavaScript (Metode Terbaik) --}}
    <script type="text/javascript">
        window.location.href = "{{ $link->target_url }}";
    </script>
</body>

</html>