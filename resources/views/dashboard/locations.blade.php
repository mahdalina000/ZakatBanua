@extends('layouts.dashboard')
@section('title', 'Lokasi Penyaluran — Zakat Banua')
@section('page-title', 'Lokasi Penyaluran')
@section('page-sub', 'Daftar titik penyaluran zakat')
@section('content')

<div class="flex flex-wrap items-center gap-2 mb-4">
    <button data-filter="all" class="fbtn bg-olive text-white px-4 py-2 rounded-full text-xs font-semibold">Semua</button>
    <button data-filter="baznas" class="fbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">BAZNAS</button>
    <button data-filter="upz" class="fbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">UPZ/Masjid</button>
    <button data-filter="warga" class="fbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold">Rumah Warga</button>
    <span id="apiStatus" class="text-xs text-olive/50 ml-auto">Memuat…</span>
</div>

<div class="bg-white rounded-[20px] border border-cream-3 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-xs text-olive/50 bg-cream">
                <th class="px-4 py-3">Nama</th><th class="px-4 py-3">Wilayah</th>
                <th class="px-4 py-3">Tipe</th><th class="px-4 py-3">Kontak</th><th class="px-4 py-3">Jam</th>
            </tr></thead>
            <tbody id="tblBody">
                <tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">Memuat data…</td></tr>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 bg-cream rounded-[16px] border border-cream-3 p-4 text-xs text-olive/60">
    <i class="fa-solid fa-circle-info text-olive mr-1"></i>
    Data bersumber dari endpoint <code class="bg-white px-1 rounded">/locations</code>.
    Penambahan &amp; pengubahan data dilakukan melalui API oleh Admin UPZ/BAZNAS.
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;
const color = { baznas: '#10b981', upz: '#f97316', warga: '#ef4444' };
const label = { baznas: 'BAZNAS', upz: 'UPZ / Masjid', warga: 'Rumah Warga' };
let rows = [], filter = 'all';

function draw() {
    const body = document.getElementById('tblBody');
    const data = rows.filter(r => filter === 'all' || r.type === filter);
    if (!data.length) { body.innerHTML = '<tr><td colspan="5" class="px-4 py-10 text-center text-olive/40">Tidak ada data.</td></tr>'; return; }
    body.innerHTML = data.map(l =>
        '<tr class="border-t border-cream-2 hover:bg-cream-2/50">' +
        '<td class="px-4 py-3"><div class="font-semibold">' + l.name + '</div><div class="text-[11px] text-olive/50">' + (l.address || '') + '</div></td>' +
        '<td class="px-4 py-3 text-xs">' + (l.kelurahan || '-') + '<br><span class="text-olive/50">' + (l.kecamatan || '-') + '</span></td>' +
        '<td class="px-4 py-3"><span class="text-[11px] px-2 py-1 rounded-full text-white" style="background:' + (color[l.type] || '#6b7280') + '">' + (label[l.type] || l.type) + '</span></td>' +
        '<td class="px-4 py-3 text-xs">' + (l.phone || '-') + '</td>' +
        '<td class="px-4 py-3 text-xs text-olive/60">' + (l.opening_hours || '-') + '</td>' +
        '</tr>').join('');
}

document.querySelectorAll('.fbtn').forEach(b => b.addEventListener('click', () => {
    filter = b.dataset.filter;
    document.querySelectorAll('.fbtn').forEach(x => x.className = 'fbtn bg-white border border-cream-3 text-olive px-4 py-2 rounded-full text-xs font-semibold');
    b.className = 'fbtn bg-olive text-white px-4 py-2 rounded-full text-xs font-semibold';
    draw();
}));

(async () => {
    const status = document.getElementById('apiStatus');
    try {
        const res = await api.locations({ per_page: 50 });
        rows = res.data || [];
        draw();
        status.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-500 mr-1"></i> ' + rows.length + ' lokasi dari API';
    } catch (e) {
        status.innerHTML = '<i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> API belum aktif';
    }
})();
</script>
@endsection