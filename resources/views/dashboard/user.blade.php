@extends('layouts.dashboard')
@section('title', 'Dashboard User — Zakat Banua')
@section('page-title')Assalamualaikum, <span id="uname">Pengguna</span>@endsection
@section('page-sub', 'Selamat datang di Zakat Banua')
@section('content')

<div class="bg-cream rounded-[20px] border border-cream-3 p-5 lg:p-6">
    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4 justify-between">
        <div>
            <div class="font-extrabold text-olive-dark text-lg">Tunaikan Zakat Anda</div>
            <p class="text-sm text-olive/60 mt-1 max-w-lg">Hitung zakat fitrah dan mal, temukan lokasi penyaluran terdekat, serta pelajari panduan zakat — semua tersedia untuk Anda.</p>
        </div>
        <a href="{{ url('/kalkulator') }}" class="bg-olive text-white font-semibold px-6 py-3 rounded-full hover:bg-olive-2 whitespace-nowrap"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-building-columns"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="cBaznas">—</div>
        <div class="text-xs font-semibold text-olive-dark">Titik BAZNAS</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-mosque"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="cUpz">—</div>
        <div class="text-xs font-semibold text-olive-dark">UPZ / Masjid</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-olive/10 text-olive rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="cAll">—</div>
        <div class="text-xs font-semibold text-olive-dark">Total Lokasi</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="text-2xl font-black mt-3" id="cBeras">—</div>
        <div class="text-xs text-cream/80">Beras Banjar /kg</div>
    </div>
</div>
<p id="apiStatus" class="mt-3 text-xs text-olive/50">Memuat…</p>

<div class="grid lg:grid-cols-3 gap-4 mt-4">
    <a href="{{ url('/kalkulator') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-calculator"></i></div>
        <div class="font-bold text-olive-dark mt-4">Kalkulator Zakat</div>
        <div class="text-sm text-olive/60 mt-1">Hitung zakat fitrah &amp; mal otomatis.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Buka <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ url('/direktori') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-earth text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="font-bold text-olive-dark mt-4">Direktori UPZ</div>
        <div class="text-sm text-olive/60 mt-1">Lihat lokasi penyaluran di Banjarbaru.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Lihat Peta <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
    <a href="{{ url('/panduan') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition">
        <div class="w-12 h-12 bg-olive-2 text-white rounded-2xl flex items-center justify-center text-lg"><i class="fa-solid fa-book-open"></i></div>
        <div class="font-bold text-olive-dark mt-4">Panduan Zakat</div>
        <div class="text-sm text-olive/60 mt-1">Niat, syarat, besaran, 8 asnaf, FAQ.</div>
        <span class="inline-flex items-center gap-2 mt-3 text-sm font-semibold text-olive">Baca <i class="fa-solid fa-arrow-right text-xs"></i></span>
    </a>
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;
const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

// nama dari localStorage (sementara)
if (window.ZB_USER && window.ZB_USER.name) {
    document.getElementById('uname').textContent = window.ZB_USER.name;
}

(async () => {
    const status = document.getElementById('apiStatus');
    try {
        const [locs, beras] = await Promise.all([api.locations({ per_page: 50 }), api.berasPrice()]);
        const list = locs.data || [];
        document.getElementById('cBaznas').textContent = list.filter(l => l.type === 'baznas').length;
        document.getElementById('cUpz').textContent = list.filter(l => l.type === 'upz').length;
        document.getElementById('cAll').textContent = locs.meta ? locs.meta.total : list.length;
        document.getElementById('cBeras').textContent = rupiah(beras.data.price);
        status.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Data live dari API';
    } catch (e) {
        status.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> API belum aktif';
    }
})();
</script>
@endsection