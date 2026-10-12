<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Zakat Banua')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream min-h-screen flex flex-col">

<header class="bg-olive text-white">
    <div class="max-w-6xl mx-auto px-4 lg:px-6 h-[60px] flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 bg-cream rounded-xl flex items-center justify-center text-olive"><i class="fa-solid fa-mosque"></i></div>
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide">ZAKAT BANUA</div>
                <div class="text-[10px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
            </div>
        </a>
        <a href="{{ url('/beranda') }}" class="text-xs bg-white/15 hover:bg-white/25 px-4 py-2 rounded-full"><i class="fa-solid fa-house mr-1"></i> Beranda</a>
    </div>
</header>

<main class="flex-1 flex items-center justify-center p-4 py-10">
    @yield('content')
</main>

<footer class="bg-olive-dark text-cream/60 text-center text-xs py-3">© {{ date('Y') }} Zakat Banua — Amanah, Transparan, Berkah</footer>

@yield('scripts')
</body>
</html>