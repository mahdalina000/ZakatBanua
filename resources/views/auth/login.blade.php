<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — Zakat Banua</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-2 min-h-screen">

<div class="min-h-screen grid lg:grid-cols-2">

    {{-- ===== PANEL KIRI — Branding (Olive) ===== --}}
    <div class="relative hidden lg:flex flex-col justify-between bg-olive text-white p-10 xl:p-14 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.07]"
             style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 30px 30px;"></div>
        <div class="absolute -bottom-24 -right-24 w-[420px] h-[420px] rounded-full bg-olive-2/40 blur-2xl"></div>

        <div class="relative flex items-center gap-3">
            <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center p-1 shadow">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Zakat Banua" class="w-full h-full object-contain">
            </div>
            <div class="leading-tight">
                <div class="font-extrabold tracking-wide">ZAKAT BANUA</div>
                <div class="text-[10px] tracking-[0.22em] text-cream/70">BANJARBARU</div>
            </div>
        </div>

        <div class="relative max-w-md">
            <div class="text-[11px] tracking-[0.28em] font-semibold text-earth">SELAMAT DATANG KEMBALI</div>
            <h1 class="font-playfair font-bold text-[40px] xl:text-[48px] leading-[1.05] mt-3">
                Selamat Datang di <span class="text-earth">Zakat Banua</span>.
            </h1>
            <p class="mt-4 text-sm text-cream/80 leading-relaxed">Hitung zakat dengan mudah dan kelola informasi zakat Anda dalam satu tempat.</p>

            <div class="mt-8 flex flex-wrap gap-3 text-xs">
                <span class="bg-white/10 border border-white/15 px-3 py-1.5 rounded-full"><i class="fa-solid fa-shield-halved mr-1 text-earth"></i> Amanah</span>
                <span class="bg-white/10 border border-white/15 px-3 py-1.5 rounded-full"><i class="fa-solid fa-eye mr-1 text-earth"></i> Transparan</span>
                <span class="bg-white/10 border border-white/15 px-3 py-1.5 rounded-full"><i class="fa-solid fa-hand-holding-heart mr-1 text-earth"></i> Berkah</span>
            </div>
        </div>

        <div class="relative text-xs text-cream/60 italic">Bersama baik, tumbuh bersama.</div>
    </div>

    {{-- ===== PANEL KANAN — Form (Cream) ===== --}}
    <div class="relative bg-cream-2 flex flex-col">
        <div class="flex items-center justify-between p-5 lg:p-7">
            <a href="{{ url('/') }}" class="lg:hidden flex items-center gap-2">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center p-0.5 border border-cream-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <span class="font-extrabold text-olive-dark text-sm">ZAKAT BANUA</span>
            </a>
            <a href="{{ url('/beranda') }}" class="ml-auto text-xs text-olive/60 hover:text-olive transition"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke beranda</a>
        </div>

        <div class="flex-1 flex items-center justify-center px-4 pb-10">
            <div class="w-full max-w-md">
                <div class="bg-white rounded-[24px] shadow-xl border border-cream-3 p-7 lg:p-8">
                    <div class="text-[11px] tracking-[0.2em] font-semibold text-olive/50">AKUN ZAKAT BANUA</div>
                    <h2 class="font-playfair font-bold text-olive-dark text-3xl mt-1">Masuk</h2>
                    <p class="text-xs text-olive/60 mt-1">Akses akun Zakat Banua Anda.</p>

                    <div id="alert" class="hidden mt-4 rounded-xl px-4 py-2.5 text-xs"></div>

                    <form id="loginForm" class="mt-5 space-y-4">
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
                                <input id="password" type="password" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Masukkan kata sandi">
                                <button type="button" id="togglePass" class="text-olive/40 hover:text-olive"><i class="fa-solid fa-eye text-sm"></i></button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs">
                            <label class="flex items-center gap-2 text-olive/70 cursor-pointer">
                                <input type="checkbox" id="remember" class="accent-olive"> Ingat Saya
                            </label>
                            <a href="#" class="text-olive font-semibold hover:underline">Lupa Kata Sandi?</a>
                        </div>

                        <button id="submitBtn" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition disabled:opacity-60">
                            <span id="btnText">Masuk <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </button>
                    </form>

                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-cream-3"></div>
                        <span class="text-[10px] tracking-[0.2em] text-olive/40 font-semibold">ATAU</span>
                        <div class="flex-1 h-px bg-cream-3"></div>
                    </div>

                    <button type="button" disabled class="w-full border border-cream-3 rounded-full py-2.5 text-sm text-olive/40 flex items-center justify-center gap-2 cursor-not-allowed" title="Akan tersedia pada pengembangan berikutnya">
                        <i class="fa-brands fa-google"></i> Lanjutkan dengan Google
                    </button>

                    <p class="text-center text-xs text-olive/60 mt-5">Belum memiliki akun? <a href="{{ url('/register') }}" class="font-semibold text-olive underline">Buat Akun</a></p>
                </div>

                <div class="mt-5">
                    <div class="text-[11px] tracking-[0.14em] font-semibold text-olive/50 text-center mb-2">— AKUN DEMO (KLIK UNTUK ISI) —</div>
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" data-email="superadmin@banjarbaru.go.id" data-pass="superadmin123" class="demo text-left bg-white border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream transition">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-violet-500"></span><span class="text-[11px] font-bold text-olive-dark">Super Admin</span></div>
                            <div class="text-[10px] text-olive/50">superadmin@banjarbaru.go.id</div>
                        </button>
                        <button type="button" data-email="admin@baznas-banjarbaru.id" data-pass="admin123" class="demo text-left bg-white border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream transition">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span><span class="text-[11px] font-bold text-olive-dark">Admin BAZNAS</span></div>
                            <div class="text-[10px] text-olive/50">admin@baznas-banjarbaru.id</div>
                        </button>
                        <button type="button" data-email="admin@upz-banjarbaru.id" data-pass="admin123" class="demo text-left bg-white border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream transition">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span><span class="text-[11px] font-bold text-olive-dark">Admin UPZ</span></div>
                            <div class="text-[10px] text-olive/50">admin@upz-banjarbaru.id</div>
                        </button>
                        <button type="button" data-email="user@gmail.com" data-pass="user123" class="demo text-left bg-white border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream transition">
                            <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span><span class="text-[11px] font-bold text-olive-dark">User</span></div>
                            <div class="text-[10px] text-olive/50">user@gmail.com</div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const api = window.ZakatApi;

document.querySelectorAll('.demo').forEach(b => {
    b.addEventListener('click', () => {
        document.getElementById('email').value = b.dataset.email;
        document.getElementById('password').value = b.dataset.pass;
        document.getElementById('email').focus();
    });
});

document.getElementById('togglePass').addEventListener('click', () => {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
});

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const alertBox = document.getElementById('alert');
    alertBox.classList.add('hidden');
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    btn.disabled = true;
    btnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses...';

    try {
        const res = await api.login(document.getElementById('email').value, document.getElementById('password').value);
        localStorage.setItem('zb_token', res.token);
        localStorage.setItem('zb_user', JSON.stringify(res.user));
        alertBox.className = 'mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-2.5 text-xs';
        alertBox.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Login berhasil sebagai <b>' + res.user.name + '</b> (' + res.user.role_label + '). Mengalihkan…';
        alertBox.classList.remove('hidden');
        setTimeout(() => { window.location.href = '{{ url("/dashboard") }}'; }, 1200);
    } catch (err) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation mr-1"></i> ' + (err.status === 401 ? 'Email atau kata sandi salah.' : 'Gagal masuk: ' + err.message + ' — pastikan API aktif.');
        alertBox.classList.remove('hidden');
        btn.disabled = false;
        btnText.innerHTML = 'Masuk <i class="fa-solid fa-arrow-right ml-1"></i>';
    }
});
</script>
</body>
</html>