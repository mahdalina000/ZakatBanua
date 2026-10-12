@extends('layouts.app')
@section('title', 'Kalkulator Zakat — Zakat Banua')
@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
    <div class="bg-cream rounded-[20px] p-5 lg:p-6 border border-cream-3">
        <h1 class="font-extrabold text-olive-dark text-xl lg:text-2xl"><i class="fa-solid fa-calculator text-olive mr-2"></i> Kalkulator Zakat</h1>
        <p class="text-sm text-olive/60 mt-1">Perhitungan dilakukan di server sesuai <b>kontrak API</b>, sehingga hasil selalu konsisten.</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button data-tab="fitrah" class="tab-btn bg-olive text-white px-5 py-2 rounded-full text-sm font-semibold">Zakat Fitrah</button>
            <button data-tab="mal" class="tab-btn bg-white border border-cream-3 text-olive px-5 py-2 rounded-full text-sm font-semibold">Zakat Mal</button>
        </div>
    </div>

    {{-- FITRAH --}}
    <div id="panel-fitrah" class="tab-panel mt-6">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark"><i class="fa-solid fa-wheat-awn text-olive mr-2"></i> Zakat Fitrah</h2>
                <p class="text-xs text-olive/60 mt-1">Wajib bagi setiap jiwa muslim menjelang Idul Fitri. Besaran 2,5 kg beras / jiwa, dikonversi sesuai harga beras terkini.</p>

                <label class="block mt-5 text-sm font-semibold text-olive-dark">Jumlah Jiwa</label>
                <div class="mt-2 flex items-center gap-3">
                    <button id="fitrahMinus" class="w-10 h-10 rounded-full bg-cream border border-cream-3 text-olive flex items-center justify-center"><i class="fa-solid fa-minus text-xs"></i></button>
                    <input id="fitrahJiwa" type="number" min="1" value="1" class="flex-1 border border-cream-3 rounded-full px-4 py-2.5 text-center font-bold text-olive-dark">
                    <button id="fitrahPlus" class="w-10 h-10 rounded-full bg-olive text-white flex items-center justify-center"><i class="fa-solid fa-plus text-xs"></i></button>
                </div>

                <button id="fitrahHit" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition"><i class="fa-solid fa-equals mr-1"></i> Hitung Zakat Fitrah</button>

                <div class="mt-5 bg-cream rounded-xl p-3 text-xs text-olive/70">
                    <i class="fa-solid fa-circle-info text-olive mr-1"></i> Harga acuan diambil otomatis dari data BAZNAS (endpoint <code class="bg-white px-1 rounded">/beras-price</code>).
                </div>
            </div>

            <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white">
                <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HASIL PERHITUNGAN</div>
                <h3 class="font-extrabold text-2xl mt-1">Zakat Fitrah</h3>
                <div class="mt-5 bg-white text-olive-dark rounded-2xl p-4">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-cream rounded-xl p-3">
                            <div class="text-xs text-olive/60">Total Beras</div>
                            <div id="outBeras" class="font-extrabold text-olive text-lg">—</div>
                        </div>
                        <div class="bg-cream rounded-xl p-3">
                            <div class="text-xs text-olive/60">Jiwa</div>
                            <div id="outJiwa" class="font-extrabold text-olive text-lg">—</div>
                        </div>
                    </div>
                    <div class="mt-4 bg-olive text-white rounded-xl p-4 text-center">
                        <div class="text-xs text-cream/80">Setara Uang</div>
                        <div id="outRupiah" class="font-black text-xl">—</div>
                        <div id="outSumber" class="text-xs text-cream/70 mt-1"></div>
                    </div>
                </div>
                <p id="fitrahErr" class="hidden mt-3 text-xs bg-red-500/20 border border-red-300/40 rounded-xl p-3"></p>
            </div>
        </div>
    </div>

    {{-- MAL --}}
    <div id="panel-mal" class="tab-panel mt-6 hidden">
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark"><i class="fa-solid fa-coins text-olive mr-2"></i> Zakat Mal (Harta)</h2>
                <p class="text-xs text-olive/60 mt-1">2,5% dari harta yang telah mencapai nishab (setara 85 gram emas).</p>

                <label class="block mt-5 text-sm font-semibold text-olive-dark">Total Harta (Rp)</label>
                <input id="malHarta" type="number" value="100000000" class="mt-2 w-full border border-cream-3 rounded-full px-4 py-2.5 text-sm">

                <button id="malHit" class="mt-5 w-full bg-olive text-white font-bold py-3 rounded-full hover:bg-olive-2 transition"><i class="fa-solid fa-equals mr-1"></i> Hitung Zakat Mal</button>
            </div>

            <div class="bg-olive rounded-[20px] p-5 lg:p-6 text-white">
                <div class="text-xs tracking-[0.14em] font-semibold text-cream/80">HASIL ZAKAT MAL</div>
                <div class="mt-4 bg-white text-olive-dark rounded-2xl p-4">
                    <div class="flex justify-between text-sm border-b border-cream-3 pb-2"><span class="text-olive/60">Nishab</span><span id="outNishab" class="font-bold">—</span></div>
                    <div class="flex justify-between text-sm mt-2 border-b border-cream-3 pb-2"><span class="text-olive/60">Harta Anda</span><span id="outHarta" class="font-bold">—</span></div>
                    <div class="mt-3 bg-cream rounded-xl p-3 text-center">
                        <div class="text-xs text-olive/60">Status</div>
                        <div id="outStatus" class="font-bold text-olive">—</div>
                    </div>
                    <div class="mt-4 bg-olive text-white rounded-xl p-4 text-center">
                        <div class="text-xs text-cream/80">Zakat yang harus dibayar</div>
                        <div id="outZakat" class="font-black text-xl">—</div>
                    </div>
                </div>
                <p id="malErr" class="hidden mt-3 text-xs bg-red-500/20 border border-red-300/40 rounded-xl p-3"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const api = window.ZakatApi;
const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');
const fmtKg = n => Number(n).toLocaleString('id-ID', { maximumFractionDigits: 2 });

// Tabs
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.className = 'tab-btn bg-white border border-cream-3 text-olive px-5 py-2 rounded-full text-sm font-semibold');
        btn.className = 'tab-btn bg-olive text-white px-5 py-2 rounded-full text-sm font-semibold';
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        document.getElementById('panel-' + btn.dataset.tab).classList.remove('hidden');
    });
});

function showErr(id, msg) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.classList.remove('hidden');
}
function hideErr(id) { document.getElementById(id).classList.add('hidden'); }

// Fitrah
async function hitFitrah() {
    hideErr('fitrahErr');
    const jiwa = Math.max(1, parseInt(document.getElementById('fitrahJiwa').value || 1));
    try {
        const res = await api.zakatFitrah(jiwa);
        const d = res.data;
        document.getElementById('outBeras').textContent = fmtKg(d.beras_kg) + ' kg';
        document.getElementById('outJiwa').textContent = d.jumlah_jiwa;
        document.getElementById('outRupiah').textContent = rupiah(d.total_rupiah);
        document.getElementById('outSumber').textContent = 'Harga acuan: ' + rupiah(d.harga_beras_per_kg) + '/kg (' + d.harga_beras_sumber + ')';
    } catch (e) {
        showErr('fitrahErr', 'Gagal menghitung: ' + e.message + ' — pastikan API/mock server aktif.');
    }
}
document.getElementById('fitrahHit').addEventListener('click', hitFitrah);
document.getElementById('fitrahMinus').addEventListener('click', () => { document.getElementById('fitrahJiwa').value = Math.max(1, parseInt(document.getElementById('fitrahJiwa').value) - 1); hitFitrah(); });
document.getElementById('fitrahPlus').addEventListener('click', () => { document.getElementById('fitrahJiwa').value = parseInt(document.getElementById('fitrahJiwa').value) + 1; hitFitrah(); });

// Mal
async function hitMal() {
    hideErr('malErr');
    const harta = parseInt(document.getElementById('malHarta').value || 0);
    try {
        const res = await api.zakatMal(harta);
        const d = res.data;
        document.getElementById('outNishab').textContent = rupiah(d.nishab);
        document.getElementById('outHarta').textContent = rupiah(d.total_harta);
        document.getElementById('outStatus').textContent = d.wajib_zakat ? 'Wajib zakat' : 'Belum mencapai nishab';
        document.getElementById('outStatus').className = d.wajib_zakat ? 'font-bold text-emerald-600' : 'font-bold text-amber-600';
        document.getElementById('outZakat').textContent = rupiah(d.zakat);
    } catch (e) {
        showErr('malErr', 'Gagal menghitung: ' + e.message + ' — pastikan API/mock server aktif.');
    }
}
document.getElementById('malHit').addEventListener('click', hitMal);

// hitung awal saat halaman dibuka
window.addEventListener('DOMContentLoaded', () => { hitFitrah(); hitMal(); });
</script>
@endsection