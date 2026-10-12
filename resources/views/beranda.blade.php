@extends('layouts.app')
@section('title', 'Beranda — Zakat Banua')
@section('content')
<section class="bg-cream">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-8 lg:py-10">
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <div>
                <div class="inline-flex items-center gap-2 bg-white border border-cream-3 px-3 py-1.5 rounded-full text-xs font-semibold text-olive"><i class="fa-solid fa-sparkles"></i> ZAKAT MEMBERSIHKAN HARTA &amp; JIWA</div>
                <h1 class="mt-4 font-extrabold text-olive-dark text-[28px] lg:text-[40px] leading-[1.05]">Mudahkan Zakat,<br><span class="text-olive">Raih Berkah.</span></h1>
                <p class="mt-3 text-sm lg:text-[15px] text-olive/70 leading-relaxed">Hitung zakat fitrah &amp; mal, temukan titik penyaluran terdekat di Banjarbaru, dan pelajari panduan lengkap sesuai syariat.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ url('/kalkulator') }}" class="bg-olive text-white font-semibold px-6 py-3 rounded-full hover:bg-olive-2 transition shadow"><i class="fa-solid fa-calculator mr-2"></i> Hitung Zakat</a>
                    <a href="{{ url('/direktori') }}" class="bg-white border border-cream-3 text-olive font-semibold px-6 py-3 rounded-full hover:bg-cream transition"><i class="fa-solid fa-map-location-dot mr-2"></i> Lihat Direktori</a>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3 text-center">
                    <div class="bg-white rounded-2xl p-3 border border-cream-3">
                        <div class="text-xl font-extrabold text-olive" id="statHarga">—</div>
                        <div class="text-xs text-olive/60">Harga Beras /kg</div>
                    </div>
                    <div class="bg-white rounded-2xl p-3 border border-cream-3">
                        <div class="text-xl font-extrabold text-olive" id="statLokasi">—</div>
                        <div class="text-xs text-olive/60">Titik Penyaluran</div>
                    </div>
                    <div class="bg-white rounded-2xl p-3 border border-cream-3">
                        <div class="text-xl font-extrabold text-olive">8</div>
                        <div class="text-xs text-olive/60">Asnaf Penerima</div>
                    </div>
                </div>
                <p id="apiStatus" class="mt-3 text-xs text-olive/50">Memuat data dari API…</p>
            </div>

            <div class="bg-white rounded-[24px] p-6 border border-cream-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-olive text-white rounded-xl flex items-center justify-center"><i class="fa-solid fa-bullhorn"></i></div>
                    <div>
                        <div class="font-bold text-olive-dark text-sm">Pengumuman Penting</div>
                        <div class="text-xs text-olive/60">Batas Zakat Fitrah 1 Syawal • Fidyah sesuai harga pasar</div>
                    </div>
                </div>
                <div class="mt-5 space-y-3">
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-olive text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-wheat-awn text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-olive-dark">Zakat Fitrah</div><div class="text-xs text-olive/60">2,5 kg beras atau 3,5 liter / jiwa</div></div>
                    </div>
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-earth text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-coins text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-olive-dark">Zakat Mal</div><div class="text-xs text-olive/60">2,5% dari harta mencapai nishab &amp; haul</div></div>
                    </div>
                    <div class="flex gap-3 bg-cream rounded-xl p-3">
                        <div class="w-8 h-8 bg-olive-2 text-white rounded-lg flex items-center justify-center flex-shrink-0"><i class="fa-solid fa-utensils text-xs"></i></div>
                        <div class="text-sm"><div class="font-semibold text-olive-dark">Fidyah Puasa</div><div class="text-xs text-olive/60">1 mud (±0,75 kg) atau 1 porsi makan / hari</div></div>
                    </div>
                </div>
                <a href="{{ url('/panduan') }}" class="mt-5 block text-center bg-cream text-olive font-semibold py-2.5 rounded-full border border-cream-3 hover:bg-cream-3 transition text-sm">Baca Panduan Lengkap <i class="fa-solid fa-arrow-right ml-1"></i></a>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 lg:px-6 py-8">
    <h2 class="font-bold text-olive-dark">Jelajahi Fitur</h2>
    <p class="text-sm text-olive/60">Pilih kebutuhan Anda — semua dalam satu tempat.</p>
    <div class="mt-4 grid md:grid-cols-3 gap-4">
        <a href="{{ url('/kalkulator') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-olive text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-calculator"></i></div>
            <div class="mt-4 font-bold text-olive-dark">Kalkulator Zakat</div>
            <div class="text-sm text-olive/60 mt-1">Hitung zakat fitrah, mal, dan fidyah — dihitung langsung di server.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Buka Kalkulator <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
        <a href="{{ url('/direktori') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-earth text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="mt-4 font-bold text-olive-dark">Direktori Maps</div>
            <div class="text-sm text-olive/60 mt-1">Peta interaktif Banjarbaru — BAZNAS, UPZ/Masjid, dan rumah warga.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Buka Peta <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
        <a href="{{ url('/panduan') }}" class="bg-white rounded-[20px] border border-cream-3 p-5 hover:shadow-md transition group">
            <div class="w-12 h-12 bg-olive-2 text-white rounded-2xl flex items-center justify-center text-lg group-hover:scale-105 transition"><i class="fa-solid fa-book-open"></i></div>
            <div class="mt-4 font-bold text-olive-dark">Panduan Zakat</div>
            <div class="text-sm text-olive/60 mt-1">Niat, syarat, waktu, besaran, 8 asnaf, dalil &amp; FAQ.</div>
            <span class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-olive">Baca Panduan <i class="fa-solid fa-arrow-right text-xs"></i></span>
        </a>
    </div>
</section>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;

const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

(async () => {
    const status = document.getElementById('apiStatus');
    try {
        const [beras, locs] = await Promise.all([api.berasPrice(), api.locations()]);
        document.getElementById('statHarga').textContent = rupiah(beras.data.price);
        document.getElementById('statLokasi').textContent = locs.meta.total;
        status.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Data live dari API';
    } catch (e) {
        status.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> API belum aktif — menampilkan nilai contoh';
        document.getElementById('statHarga').textContent = 'Rp 16.000';
        document.getElementById('statLokasi').textContent = '7';
    }
})();
</script>
@endsection