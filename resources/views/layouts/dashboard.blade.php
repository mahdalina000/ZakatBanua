<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard — Zakat Banua')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>
<body class="bg-cream-2 text-olive-dark min-h-screen">

{{-- Data user dari localStorage (sementara; nanti dari endpoint /auth/me) --}}
<script>
    window.ZB_USER = (() => { try { return JSON.parse(localStorage.getItem('zb_user')) || null; } catch { return null; } })();
    window.ZB_TOKEN = localStorage.getItem('zb_token');
</script>

<div class="flex min-h-screen">
    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="fixed lg:sticky top-0 z-50 w-[262px] h-screen bg-olive text-white flex flex-col -translate-x-full lg:translate-x-0 transition-transform">
        <div class="h-[66px] flex items-center gap-3 px-5 border-b border-white/10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto object-contain">
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide">ZAKAT BANUA</div>
                <div class="text-[10px] tracking-[0.18em] text-cream/70 -mt-0.5">DASHBOARD</div>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center"><i class="fa-solid fa-xmark text-sm"></i></button>
        </div>

        <div class="px-4 py-4 border-b border-white/10">
            <div class="flex items-center gap-3 bg-white/10 rounded-2xl p-3">
                <span id="sbAvatar" class="w-10 h-10 rounded-full bg-cream text-olive flex items-center justify-center font-bold">?</span>
                <div class="min-w-0">
                    <div id="sbName" class="text-sm font-semibold truncate">Pengguna</div>
                    <div id="sbRole" class="text-[10px] text-cream/70 truncate">—</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mb-2">MENU</div>
            <a href="{{ url('/dashboard') }}" data-nav="dashboard" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-gauge-high w-4"></i> Dashboard</a>

            {{-- Super Admin --}}
            <a href="{{ url('/dashboard/users') }}" data-role="super_admin" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-users w-4"></i> Manajemen User</a>

            {{-- Super + Admin --}}
            <a href="{{ url('/dashboard/locations') }}" data-role="super_admin" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-map-location-dot w-4"></i> Semua Lokasi</a>
            <a href="{{ url('/dashboard/locations') }}" data-role="admin" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-map-location-dot w-4"></i> Lokasi Saya</a>
            <a href="{{ url('/dashboard/beras') }}" data-role="admin" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-wheat-awn w-4"></i> Harga Beras</a>
            <a href="{{ url('/dashboard/beras') }}" data-role="super_admin" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-wheat-awn w-4"></i> Harga Beras</a>

            {{-- User --}}
            <a href="{{ url('/kalkulator') }}" data-role="user" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-calculator w-4"></i> Kalkulator Zakat</a>
            <a href="{{ url('/direktori') }}" data-role="user" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-map-location-dot w-4"></i> Direktori UPZ</a>
            <a href="{{ url('/panduan') }}" data-role="user" class="nav-item hidden flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-book-open w-4"></i> Panduan Zakat</a>

            <div class="text-[10px] tracking-[0.16em] text-cream/50 px-3 mt-4 mb-2">PUBLIK</div>
            <a href="{{ url('/beranda') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-cream hover:bg-white/10"><i class="fa-solid fa-house w-4"></i> Beranda Situs</a>
        </nav>

        <div class="p-3 border-t border-white/10">
            <button onclick="logout()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-red-200 hover:bg-red-500/20 transition"><i class="fa-solid fa-right-from-bracket w-4"></i> Keluar</button>
        </div>
    </aside>

    <div id="overlay" onclick="toggleSidebar()" class="hidden fixed inset-0 bg-black/40 z-40 lg:hidden"></div>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 min-w-0">
        <header class="sticky top-0 z-30 bg-cream-2/90 backdrop-blur border-b border-cream-3">
            <div class="px-4 lg:px-8 h-[66px] flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 bg-white border border-cream-3 rounded-xl flex items-center justify-center"><i class="fa-solid fa-bars"></i></button>
                    <div>
                        <div class="font-bold text-olive-dark text-sm lg:text-base">@yield('page-title', 'Dashboard')</div>
                        <div class="text-xs text-olive/50 hidden sm:block">@yield('page-sub', '')</div>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-xs">
                    <span class="hidden sm:inline bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive"><i class="fa-regular fa-calendar mr-1"></i> {{ now()->translatedFormat('d M Y') }}</span>
                    <span id="hdRole" class="bg-olive text-cream px-3 py-1.5 rounded-full">—</span>
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            @yield('content')
        </div>
    </div>
</div>

<script>
    const API_BASE = window.ZAKAT_API_URL || (location.origin + '/api');

    function toggleSidebar() {
        const s = document.getElementById('sidebar'), o = document.getElementById('overlay');
        s.classList.toggle('-translate-x-full'); o.classList.toggle('hidden');
    }

    // Sesuaikan menu berdasar role (dari API)
    function applyRole(user) {
        const role = user ? user.role : null;
        document.getElementById('sbName').textContent = user ? user.name : 'Pengguna';
        document.getElementById('sbRole').textContent = user ? user.role_label : '—';
        document.getElementById('sbAvatar').textContent = user ? user.name.charAt(0).toUpperCase() : '?';
        document.getElementById('hdRole').textContent = user ? user.role_label : '—';

        const isAdmin = role === 'admin_baznas' || role === 'admin_upz' || role === 'admin';
        document.querySelectorAll('[data-role]').forEach(el => {
            const r = el.dataset.role;
            const show = (r === 'super_admin' && role === 'super_admin')
                || (r === 'admin' && isAdmin)
                || (r === 'user' && role === 'user');
            if (show) el.classList.remove('hidden');
        });
    }

    async function loadUser() {
        // pakai token bila ada; kalau tidak, pakai data localStorage
        if (window.ZB_TOKEN) {
            try {
                const r = await fetch(API_BASE + '/auth/me', { headers: { 'Authorization': 'Bearer ' + window.ZB_TOKEN, 'Accept': 'application/json' } });
                if (r.ok) { const d = await r.json(); return d.data || d.user || d; }
            } catch (e) { /* jatuh ke localStorage */ }
        }
        return window.ZB_USER;
    }

    function logout() {
        localStorage.removeItem('zb_token');
        localStorage.removeItem('zb_user');
        window.location.href = '{{ url("/login") }}';
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const user = await loadUser();
        applyRole(user);
        // tandai menu aktif
        const path = window.location.pathname;
        document.querySelectorAll('.nav-item').forEach(a => { if (path.endsWith(new URL(a.href).pathname)) a.classList.add('bg-white','text-olive','font-semibold'); });
    });
</script>
@yield('scripts')
</body>
</html>