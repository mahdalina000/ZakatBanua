@extends('layouts.guest')
@section('title', 'Masuk — Zakat Banua')
@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-[24px] shadow-xl border border-cream-3 p-7">
        <div class="text-center">
            <div class="w-14 h-14 bg-olive rounded-2xl flex items-center justify-center text-cream text-2xl mx-auto"><i class="fa-solid fa-mosque"></i></div>
            <h1 class="mt-4 font-extrabold text-olive-dark text-xl">Masuk ke Zakat Banua</h1>
            <p class="text-xs text-olive/60 mt-1">Gunakan akun Anda atau pilih akun demo.</p>
        </div>

        <div id="alert" class="hidden mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs"></div>

        <form id="loginForm" class="mt-5 space-y-4">
            <div>
                <label class="text-xs font-semibold text-olive-dark">Email</label>
                <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2">
                    <i class="fa-solid fa-envelope text-olive/50 text-sm"></i>
                    <input id="email" name="email" type="email" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="nama@email.com">
                </div>
            </div>
            <div>
                <label class="text-xs font-semibold text-olive-dark">Password</label>
                <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2">
                    <i class="fa-solid fa-lock text-olive/50 text-sm"></i>
                    <input id="password" name="password" type="password" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="••••••••">
                    <button type="button" id="togglePass" class="text-olive/40 hover:text-olive"><i class="fa-solid fa-eye text-sm"></i></button>
                </div>
            </div>
            <button id="submitBtn" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition disabled:opacity-60">
                <span id="btnText">Masuk <i class="fa-solid fa-arrow-right ml-1"></i></span>
            </button>
        </form>

        <div class="mt-5">
            <div class="text-[11px] tracking-[0.14em] font-semibold text-olive/50 text-center mb-2">— AKUN DEMO (KLIK UNTUK ISI) —</div>
            <div class="grid gap-2" id="demoAccounts">
                <button type="button" data-email="superadmin@banjarbaru.go.id" data-pass="superadmin123" class="demo w-full text-left bg-cream border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream-3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-violet-500"></span><span class="text-xs font-bold text-olive-dark">Super Admin — Pemko Banjarbaru</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">superadmin@banjarbaru.go.id / superadmin123</div>
                </button>
                <button type="button" data-email="admin@baznas-banjarbaru.id" data-pass="admin123" class="demo w-full text-left bg-cream border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream-3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span><span class="text-xs font-bold text-olive-dark">Admin BAZNAS</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">admin@baznas-banjarbaru.id / admin123</div>
                </button>
                <button type="button" data-email="admin@upz-banjarbaru.id" data-pass="admin123" class="demo w-full text-left bg-cream border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream-3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-orange-500"></span><span class="text-xs font-bold text-olive-dark">Admin UPZ — Masjid Al-Munawwarah</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">admin@upz-banjarbaru.id / admin123</div>
                </button>
                <button type="button" data-email="user@gmail.com" data-pass="user123" class="demo w-full text-left bg-cream border border-cream-3 rounded-xl px-3 py-2 hover:bg-cream-3 transition">
                    <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-sky-500"></span><span class="text-xs font-bold text-olive-dark">User — Warga Banjarbaru</span></div>
                    <div class="text-[11px] text-olive/50 ml-4">user@gmail.com / user123</div>
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-olive/60 mt-5">Belum punya akun? <a href="{{ url('/register') }}" class="font-semibold text-olive underline">Daftar di sini</a></p>
    </div>
    <p class="text-center text-xs text-olive/50 mt-4"><a href="{{ url('/') }}" class="hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a></p>
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;

// isi otomatis akun demo
document.querySelectorAll('.demo').forEach(b => {
    b.addEventListener('click', () => {
        document.getElementById('email').value = b.dataset.email;
        document.getElementById('password').value = b.dataset.pass;
        document.getElementById('email').focus();
    });
});

// tampilkan / sembunyikan password
document.getElementById('togglePass').addEventListener('click', () => {
    const p = document.getElementById('password');
    p.type = p.type === 'password' ? 'text' : 'password';
});

// submit ke API (endpoint sesuai openapi.yaml)
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const alertBox = document.getElementById('alert');
    alertBox.classList.add('hidden');
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    btn.disabled = true;
    btnText.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Memproses...';

    try {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const res = await api.login(email, password);
        // simpan token & info user (sementara, sebelum halaman dashboard ada)
        localStorage.setItem('zb_token', res.token);
        localStorage.setItem('zb_user', JSON.stringify(res.user));
        alertBox.className = 'mt-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Login berhasil sebagai ' + res.user.name + ' (' + res.user.role_label + '). Mengalihkan…';
        alertBox.classList.remove('hidden');
        setTimeout(() => { window.location.href = '{{ url("/beranda") }}'; }, 1200);
    } catch (err) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = err.status === 401
            ? 'Email atau password salah.'
            : 'Gagal masuk: ' + err.message + ' — pastikan API aktif.';
        alertBox.classList.remove('hidden');
        btn.disabled = false;
        btnText.innerHTML = 'Masuk <i class="fa-solid fa-arrow-right ml-1"></i>';
    }
});
</script>
@endsection