<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Menggunakan nama dari .env (APP_NAME), jika tidak ada otomatis pakai 'BANINA' --}}
    <title>@yield('title', config('app.name', 'BANINA') . ' - Busana Muslim Pria')</title>
    
    {{-- Menggunakan deskripsi default jika controller tidak mengirimkan deskripsi custom --}}
    <meta name="description" content="@yield('meta_description', 'Koleksi busana muslim pria premium dan modern dari BANINA.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>
        :root {
            --gold: #7a8c2a;
            --gold-light: #9aad3a;
            --gold-dim: #5a6820;
            --border-gold: rgba(122,140,42,0.3);
        }
    </style>

    @stack('css')
</head>

<body>

    @include('frontend.layouts.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    <script src="{{ asset('assets/js/main.js') }}"></script>

    @stack('js')

</body>
</html>