<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Zakat Banua</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-2 min-h-screen">

<div class="min-h-screen grid lg:grid-cols-2">

    {{-- ===== PANEL KIRI — Branding ===== --}}
    <div class="relative hidden lg:flex flex-col justify-between bg-olive text-white p-10 xl:p-14 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.07]"
             style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 30px 30px;"></div>
        <div class="absolute -bottom-24 -left-24 w-[420px] h-[420px] rounded-full bg-olive-2/40 blur-2xl"></div>

        <div class="relative flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Zakat Banua" class="h-11 w-auto object-contain">
            <div class="leading-tight">
                <div class="font-extrabold tracking-wide">ZAKAT BANUA</div>
                <div class="text-[10px] tracking-[0.22em] text-cream/70">BANJARBARU</div>
            </div>
        </div>

        <div class="relative max-w-md">
            <div class="text-[11px] tracking-[0.28em] font-semibold text-earth">GABUNG BERSAMA KAMI</div>
            <h1 class="font-playfair font-bold text-[40px] xl:text-[48px] leading-[1.05] mt-3">
                Mulai Perjalanan <span class="text-earth">Zakat</span> Anda.
            </h1>
            <p class="mt-4 text-sm text-cream/80 leading-relaxed">Buat akun untuk menghitung zakat, menemukan lokasi penyaluran, dan mengelola informasi zakat Anda.</p>
        </div>

        <div class="relative text-xs text-cream/60 italic">Bersama baik, tumbuh bersama.</div>
    </div>

    {{-- ===== PANEL KANAN — Form ===== --}}
    <div class="relative bg-cream-2 flex flex-col">
        <div class="flex items-center justify-between p-5 lg:p-7">
            <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto object-contain">
                <span class="font-extrabold text-olive-dark text-sm">ZAKAT BANUA</span>
            </a>
            <a href="{{ url('/beranda') }}" class="ml-auto text-xs text-olive/60 hover:text-olive transition"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke beranda</a>
        </div>

        <div class="flex-1 flex items-center justify-center px-4 pb-10">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-[24px] shadow-xl border border-cream-3 p-7 lg:p-8">
                    <div class="text-[11px] tracking-[0.2em] font-semibold text-olive/50">AKUN ZAKAT BANUA</div>
                    <h2 class="font-playfair font-bold text-olive-dark text-3xl mt-1">Buat Akun</h2>
                    <p class="text-xs text-olive/60 mt-1">Daftar untuk mengakses layanan Zakat Banua.</p>

                    <div id="alert" class="hidden mt-4 rounded-xl px-4 py-2.5 text-xs"></div>

                    <form id="registerForm" class="mt-5 space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-olive-dark">Nama Lengkap</label>
                            <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2 focus-within:border-olive transition">
                                <i class="fa-solid fa-user text-olive/40 text-sm"></i>
                                <input id="name" type="text" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Nama Anda">
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-olive-dark">Alamat Email</label>
                            <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2 focus-within:border-olive transition">
                                <i class="fa-solid fa-envelope text-olive/40 text-sm"></i>
                                <input id="email" type="email" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="nama@email.com">
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-olive-dark">Kata Sandi</label>
                            <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2 focus-within:border-olive transition">
                                <i class="fa-solid fa-lock text-olive/40 text-sm"></i>
                                <input id="password" type="password" required minlength="8" class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Minimal 8 karakter">
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-olive-dark">Ulangi Kata Sandi</label>
                            <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2 focus-within:border-olive transition">
                                <i class="fa-solid fa-lock text-olive/40 text-sm"></i>
                                <input id="password_confirmation" type="password" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Ulangi kata sandi">
                            </div>
                        </div>
                        <button id="submitBtn" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition disabled:opacity-60">
                            <span id="btnText">Buat Akun <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </button>
                    </form>

                    <p class="text-center text-xs text-olive/60 mt-5">Sudah memiliki akun? <a href="{{ url('/login') }}" class="font-semibold text-olive underline">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const api = window.ZakatApi;

document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const alertBox = document.getElementById('alert');
    alertBox.classList.add('hidden');

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;

    if (password.length < 8) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Kata sandi minimal 8 karakter.';
        alertBox.classList.remove('hidden');
        return;
    }
    if (password !== confirm) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Konfirmasi kata sandi tidak sama.';
        alertBox.classList.remove('hidden');
        return;
    }

    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    btn.disabled = true;
    btnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses...';

    try {
        const res = await api.register({ name, email, password, password_confirmation: confirm });
        alertBox.className = 'mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-2.5 text-xs';
        alertBox.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> ' + (res.message || 'Pendaftaran berhasil') + '. Mengalihkan ke halaman masuk…';
        alertBox.classList.remove('hidden');
        setTimeout(() => { window.location.href = '{{ url("/login") }}'; }, 1500);
    } catch (err) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> Gagal mendaftar: ' + err.message + ' — pastikan API aktif.';
        alertBox.classList.remove('hidden');
        btn.disabled = false;
        btnText.innerHTML = 'Buat Akun <i class="fa-solid fa-arrow-right ml-1"></i>';
    }
});
</script>
</body>
</html>