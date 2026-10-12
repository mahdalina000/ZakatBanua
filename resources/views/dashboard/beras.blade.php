@extends('layouts.dashboard')
@section('title', 'Harga Beras Banjar — Zakat Banua')
@section('page-title', 'Pengelolaan Harga Beras Banjar')
@section('page-sub', 'Acuan perhitungan Zakat Fitrah')
@section('content')

<div class="grid lg:grid-cols-3 gap-4">
    <div class="lg:col-span-1 space-y-4">
        <div class="bg-olive rounded-[20px] p-5 text-white">
            <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HARGA SAAT INI</div>
            <div class="text-4xl font-black mt-2" id="hargaKini">—</div>
            <div class="text-cream/70 text-xs">per kilogram Beras Banjar</div>
            <div class="mt-3 text-xs text-cream/70" id="hargaInfo">—</div>
        </div>

        <div class="bg-white rounded-[20px] border border-cream-3 p-5">
            <div class="font-bold text-olive-dark text-sm"><i class="fa-solid fa-pen-to-square text-olive mr-2"></i> Perbarui Harga</div>
            <div id="alert" class="hidden mt-3 rounded-xl px-4 py-2.5 text-xs"></div>
            <div class="mt-3">
                <label class="text-xs font-semibold text-olive-dark">Harga baru (Rp / kg)</label>
                <div class="mt-1 flex items-center border border-cream-3 rounded-full px-4 py-2.5 bg-cream-2 focus-within:border-olive transition">
                    <span class="text-sm text-olive">Rp</span>
                    <input id="hargaInput" type="number" min="5000" max="100000" class="w-full bg-transparent outline-none text-sm ml-2" placeholder="16000">
                </div>
                <p class="text-[11px] text-olive/50 mt-1">Valid: Rp5.000 – Rp100.000 per kg.</p>
            </div>
            <div class="mt-3">
                <label class="text-xs font-semibold text-olive-dark">Catatan perubahan</label>
                <input id="noteInput" class="mt-1 w-full border border-cream-3 rounded-full px-4 py-2.5 text-sm bg-cream-2 outline-none focus:border-olive" placeholder="mis. Penyesuaian harga pasar">
            </div>
            <button id="saveBtn" class="mt-4 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition disabled:opacity-60">
                <span id="saveText"><i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Harga Baru</span>
            </button>
            <p class="text-[11px] text-olive/50 mt-3"><i class="fa-solid fa-circle-info mr-1"></i> Perubahan dikirim ke endpoint <code class="bg-cream px-1 rounded">PUT /beras-price</code> (memerlukan hak akses backend).</p>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-[20px] border border-cream-3 p-5">
            <div class="font-bold text-olive-dark text-sm mb-3"><i class="fa-solid fa-chart-line text-olive mr-2"></i> Informasi Harga</div>
            <div class="bg-cream rounded-xl p-5">
                <div class="flex items-baseline gap-2">
                    <div class="text-3xl font-black text-olive" id="hargaBesar">—</div>
                    <div class="text-xs text-olive/60">/ kg</div>
                </div>
                <div class="text-xs text-olive/60 mt-2" id="hargaNote">—</div>
                <div class="text-[11px] text-olive/50 mt-1" id="hargaUpdater">—</div>
            </div>
            <div class="mt-4 text-xs text-olive/60 leading-relaxed">
                Harga ini digunakan otomatis oleh <b>Kalkulator Zakat Fitrah</b> sebagai acuan konversi
                beras ke rupiah. Riwayat perubahan harga dikelola oleh backend.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;

const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');
async function load() {
    try {
        const res = await api.berasPrice();
        const d = res.data;
        document.getElementById('hargaKini').textContent = rupiah(d.price);
        document.getElementById('hargaBesar').textContent = rupiah(d.price);
        document.getElementById('hargaInput').value = d.price;
        document.getElementById('hargaNote').textContent = d.note ? '"' + d.note + '"' : '';
        document.getElementById('hargaUpdater').textContent = d.updater ? 'Diperbarui oleh ' + d.updater.name : '';
        document.getElementById('hargaInfo').innerHTML = '<i class="fa-regular fa-clock mr-1"></i> ' + (d.note || 'Harga acuan BAZNAS');
    } catch (e) {
        document.getElementById('hargaKini').textContent = 'Rp 16.000';
        document.getElementById('hargaBesar').textContent = 'Rp 16.000';
        document.getElementById('hargaNote').textContent = 'API belum aktif — menampilkan nilai contoh.';
    }
}

document.getElementById('saveBtn').addEventListener('click', async () => {
    const alertBox = document.getElementById('alert');
    alertBox.classList.add('hidden');
    const harga = parseInt(document.getElementById('hargaInput').value || 0);
    if (harga < 5000 || harga > 100000) {
        alertBox.className = 'mt-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Harga harus antara Rp5.000 dan Rp100.000 per kg.';
        alertBox.classList.remove('hidden');
        return;
    }
    const btn = document.getElementById('saveBtn');
    btn.disabled = true;
    document.getElementById('saveText').innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Menyimpan...';
    try {
        // PUT /beras-price memerlukan bearerAuth (hak admin) — dari backend
        await fetch((window.ZAKAT_API_URL || (location.origin + '/api')) + '/beras-price', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'Authorization': 'Bearer ' + (window.ZB_TOKEN || '') },
            body: JSON.stringify({ price: harga, note: document.getElementById('noteInput').value })
        }).then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); });
        alertBox.className = 'mt-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Harga berhasil diperbarui.';
        alertBox.classList.remove('hidden');
        load();
    } catch (e) {
        alertBox.className = 'mt-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-2.5 text-xs';
        alertBox.textContent = 'Belum dapat menyimpan: ' + e.message + '. Perlu endpoint backend dengan hak admin.';
        alertBox.classList.remove('hidden');
    }
    btn.disabled = false;
    document.getElementById('saveText').innerHTML = '<i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Harga Baru';
});

load();
</script>
@endsection