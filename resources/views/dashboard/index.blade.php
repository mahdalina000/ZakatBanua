@extends('layouts.dashboard')
@section('title', 'Dashboard — Zakat Banua')
@section('page-title', 'Dashboard')
@section('page-sub', 'Ringkasan sistem Zakat Banua')
@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
@endsection
@section('content')

{{-- Statistik (diisi dari API) --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-violet-100 text-violet-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-user-tie"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="sAdmin">—</div>
        <div class="text-xs font-semibold text-olive-dark">Admin UPZ/BAZNAS</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-users"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="sUser">—</div>
        <div class="text-xs font-semibold text-olive-dark">Pengguna Terdaftar</div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream-3 p-4">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="text-3xl font-black text-olive-dark mt-3" id="sLokasi">—</div>
        <div class="text-xs font-semibold text-olive-dark">Total Lokasi</div>
    </div>
    <div class="bg-olive rounded-[20px] p-4 text-white">
        <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-wheat-awn"></i></div>
        <div class="text-2xl font-black mt-3" id="sBeras">—</div>
        <div class="text-xs text-cream/80">Harga Beras /kg</div>
    </div>
</div>
<p id="apiStatus" class="mt-3 text-xs text-olive/50">Memuat data dari API…</p>

{{-- Grafik --}}
<div class="grid lg:grid-cols-2 gap-4 mt-4">
    <div class="bg-white rounded-[20px] border border-cream-3 p-5">
        <div class="font-bold text-olive-dark text-sm">Komposisi Lokasi</div>
        <div class="text-xs text-olive/50">Berdasarkan tipe penyaluran</div>
        <div class="mt-4 flex items-center gap-4">
            <div class="w-1/2"><canvas id="lokasiChart" height="150"></canvas></div>
            <div class="w-1/2 space-y-2 text-xs">
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500"></span> BAZNAS <b class="ml-auto" id="cBaznas">0</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-500"></span> UPZ/Masjid <b class="ml-auto" id="cUpz">0</b></div>
                <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span> Rumah Warga <b class="ml-auto" id="cWarga">0</b></div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-[20px] border border-cream-3 p-5">
        <div class="font-bold text-olive-dark text-sm">Harga Beras Banjar</div>
        <div class="text-xs text-olive/50">Acuan perhitungan zakat fitrah</div>
        <div class="mt-5 bg-cream rounded-xl p-5 text-center">
            <div class="text-4xl font-black text-olive" id="berasBesar">—</div>
            <div class="text-xs text-olive/60 mt-1">per kilogram</div>
            <div class="text-[11px] text-olive/50 mt-3" id="berasKet">—</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;
const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');

(async () => {
    const status = document.getElementById('apiStatus');
    try {
        const locs = await api.locations();
        const list = locs.data || [];
        document.getElementById('sLokasi').textContent = locs.meta ? locs.meta.total : list.length;
        const c = { baznas: 0, upz: 0, warga: 0 };
        list.forEach(l => { if (c[l.type] !== undefined) c[l.type]++; });
        document.getElementById('cBaznas').textContent = c.baznas;
        document.getElementById('cUpz').textContent = c.upz;
        document.getElementById('cWarga').textContent = c.warga;

        new Chart(document.getElementById('lokasiChart'), {
            type: 'doughnut',
            data: { labels: ['BAZNAS','UPZ/Masjid','Rumah Warga'], datasets: [{ data: [c.baznas, c.upz, c.warga], backgroundColor: ['#10b981','#f97316','#ef4444'], borderWidth: 0 }] },
            options: { plugins: { legend: { display: false } }, cutout: '65%' }
        });

        try {
            const b = await api.berasPrice();
            document.getElementById('sBeras').textContent = rupiah(b.data.price);
            document.getElementById('berasBesar').textContent = rupiah(b.data.price);
            document.getElementById('berasKet').textContent = (b.data.note || '') + ' · oleh ' + (b.data.updater ? b.data.updater.name : 'sistem');
        } catch (e) { /* abaikan */ }

        status.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> Data live dari API';
    } catch (e) {
        status.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> API belum aktif — nilai contoh ditampilkan';
    }

    // jumlah user & admin (dari data user bila tersedia; sementara nilai contoh)
    document.getElementById('sAdmin').textContent = '4';
    document.getElementById('sUser').textContent = '7';
})();
</script>
@endsection