@extends('layouts.guest')
@section('title', 'Daftar — Zakat Banua')
@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-[24px] shadow-xl border border-cream-3 p-7">
        <div class="text-center">
            <div class="w-14 h-14 bg-olive rounded-2xl flex items-center justify-center text-cream text-2xl mx-auto"><i class="fa-solid fa-user-plus"></i></div>
            <h1 class="mt-4 font-extrabold text-olive-dark text-xl">Daftar Akun Masyarakat</h1>
            <p class="text-xs text-olive/60 mt-1">Buat akun untuk mengakses layanan Zakat Banua.</p>
        </div>

        <div id="alert" class="hidden mt-4 rounded-xl px-4 py-2.5 text-xs"></div>

        <form id="registerForm" class="mt-5 space-y-4">
            <div>
                <label class="text-xs font-semibold text-olive-dark">Nama Lengkap</label>
                <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2">
                    <i class="fa-solid fa-user text-olive/50 text-sm"></i>
                    <input id="name" name="name" type="text" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Nama Anda">
                </div>
            </div>
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
                    <input id="password" name="password" type="password" required minlength="8" class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Minimal 8 karakter">
                </div>
                <p id="passHint" class="text-[11px] text-olive/50 mt-1">Minimal 8 karakter.</p>
            </div>
            <div>
                <label class="text-xs font-semibold text-olive-dark">Ulangi Password</label>
                <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2">
                    <i class="fa-solid fa-lock text-olive/50 text-sm"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full bg-transparent outline-none text-sm ml-2" placeholder="Ulangi password">
                </div>
            </div>
            <button id="submitBtn" class="w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition disabled:opacity-60">
                <span id="btnText">Daftar Sekarang</span>
            </button>
        </form>

        <p class="text-center text-xs text-olive/60 mt-5">Sudah punya akun? <a href="{{ url('/login') }}" class="font-semibold text-olive underline">Masuk</a></p>
    </div>
    <p class="text-center text-xs text-olive/50 mt-4"><a href="{{ url('/') }}" class="hover:underline"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke halaman utama</a></p>
</div>
@endsection

@section('scripts')
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

    // validasi tampilan (server tetap memvalidasi ulang)
    if (password.length < 8) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Password minimal 8 karakter.';
        alertBox.classList.remove('hidden');
        return;
    }
    if (password !== confirm) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Konfirmasi password tidak sama.';
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
        alertBox.textContent = (res.message || 'Pendaftaran berhasil') + '. Mengalihkan ke halaman masuk…';
        alertBox.classList.remove('hidden');
        setTimeout(() => { window.location.href = '{{ url("/login") }}'; }, 1500);
    } catch (err) {
        alertBox.className = 'mt-4 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Gagal mendaftar: ' + err.message + ' — pastikan API aktif.';
        alertBox.classList.remove('hidden');
        btn.disabled = false;
        btnText.textContent = 'Daftar Sekarang';
    }
});
</script>
@endsection