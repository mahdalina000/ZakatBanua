@extends('layouts.app')
@section('title', 'Panduan Zakat — Zakat Banua')
@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
    <div class="bg-cream rounded-[20px] p-5 lg:p-6 border border-cream-3">
        <h1 class="font-extrabold text-olive-dark text-xl lg:text-2xl"><i class="fa-solid fa-book-open text-olive mr-2"></i> Panduan Zakat Lengkap</h1>
        <p class="text-sm text-olive/60 mt-1">Pahami niat, syarat, waktu, besaran, 8 asnaf, dalil, dan tanya jawab — ringkas dan sesuai rujukan syariat.</p>
        <div class="mt-4 flex flex-wrap gap-2 text-xs">
            <a href="#niat" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Niat</a>
            <a href="#fitrah" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Zakat Fitrah</a>
            <a href="#mal" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Zakat Mal</a>
            <a href="#fidyah" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Fidyah</a>
            <a href="#asnaf" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">8 Asnaf</a>
            <a href="#faq" class="bg-white border border-cream-3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">FAQ</a>
        </div>
    </div>

    <div class="mt-6 grid lg:grid-cols-[1fr_300px] gap-6">
        <div class="space-y-6">
            {{-- Niat --}}
            <div id="niat" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">1</span> Niat Zakat</h2>
                <p class="text-xs text-olive/60 mt-1">Niat di dalam hati; melafalkan membantu menguatkan.</p>
                <div class="mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 border border-cream-3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT FITRAH UNTUK DIRI SENDIRI</div>
                        <div class="font-amiri text-olive-dark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَنْ نَفْسِي فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-olive-dark mt-2 italic">"Nawaitu an ukhrija zakatal fitri 'an nafsi fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Aku niat mengeluarkan zakat fitrah untuk diriku sendiri, fardu karena Allah Ta'ala.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream-3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT FITRAH UNTUK KELUARGA</div>
                        <div class="font-amiri text-olive-dark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَنِّي وَعَنْ جَمِيعِ مَنْ تَلْزَمُنِي نَفَقَتُهُ فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-olive-dark mt-2 italic">"Nawaitu an ukhrija zakatal fitri 'anni wa 'an jami'i man talzamuni nafaqatuhu fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Untuk kepala keluarga yang menanggung istri/anak.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream-3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT MAL</div>
                        <div class="font-amiri text-olive-dark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ مَالِي فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-olive-dark mt-2 italic">"Nawaitu an ukhrija zakata mali fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Aku niat mengeluarkan zakat hartaku fardu karena Allah Ta'ala.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream-3">
                        <div class="text-xs font-bold tracking-wide text-olive">MEWAKILKAN (LEWAT AMIL)</div>
                        <div class="text-sm text-olive-dark mt-2">Cukup niat di hati saat menyerahkan. Amil mendoakan: <span class="italic">"Ajarakallahu fima a'thaita..."</span> — Semoga Allah memberi pahala atas apa yang engkau berikan.</div>
                        <div class="text-xs text-olive/60 mt-2">Tidak wajib melafalkan di depan amil; keikhlasan hati yang utama.</div>
                    </div>
                </div>
            </div>

            {{-- Fitrah --}}
            <div id="fitrah" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">2</span> Zakat Fitrah</h2>
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-olive-dark">Hukum</div><div class="text-olive/70 text-xs mt-1">Wajib bagi setiap muslim yang memiliki kelebihan makanan pokok di malam &amp; hari Id.</div></div>
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-olive-dark">Besaran</div><div class="text-olive/70 text-xs mt-1">1 sha' = <b>2,5 kg beras</b> (atau 3,5 liter) per jiwa, sesuai harga beras lokal.</div></div>
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-olive-dark">Waktu</div><div class="text-olive/70 text-xs mt-1">Terbaik: akhir Ramadhan hingga sebelum shalat Id.</div></div>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-olive text-white rounded-xl p-4">
                            <div class="text-xs text-cream/80">CONTOH CEPAT</div>
                            <div class="font-bold mt-1">Keluarga 4 jiwa × 2,5 kg</div>
                            <div class="text-cream/80 text-xs mt-1">Hitung otomatis pecahkan harga beras terkini.</div>
                            <a href="{{ url('/kalkulator') }}" class="inline-block mt-3 bg-white text-olive text-xs font-semibold px-4 py-1.5 rounded-full">Hitung di Kalkulator &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mal --}}
            <div id="mal" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">3</span> Zakat Mal (Harta)</h2>
                <div class="mt-4 text-sm text-olive/70 leading-relaxed">
                    <p>Zakat mal wajib atas harta yang memenuhi <b class="text-olive-dark">nishab &amp; haul</b>. Kadar umum <b class="text-olive-dark">2,5%</b>.</p>
                    <div class="mt-4 grid md:grid-cols-3 gap-3">
                        <div class="bg-cream rounded-xl p-3 border border-cream-3"><div class="font-bold text-olive-dark">Nishab</div><div class="text-xs mt-1">Setara <b>85 gram emas</b>.</div></div>
                        <div class="bg-cream rounded-xl p-3 border border-cream-3"><div class="font-bold text-olive-dark">Haul</div><div class="text-xs mt-1">Harta bertahan <b>1 tahun hijriah</b> di atas nishab.</div></div>
                        <div class="bg-cream rounded-xl p-3 border border-cream-3"><div class="font-bold text-olive-dark">Kadar</div><div class="text-xs mt-1"><b>2,5%</b> dari harta kena zakat.</div></div>
                    </div>
                </div>
            </div>

            {{-- Fidyah --}}
            <div id="fidyah" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">4</span> Fidyah Puasa</h2>
                <p class="text-sm text-olive/70 mt-2">Bagi yang tidak mampu berpuasa dan tidak ada harapan sembuh. Wajib fidyah sebagai pengganti.</p>
                <div class="mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 border border-cream-3">
                        <div class="font-semibold text-olive-dark text-sm">Besaran</div>
                        <ul class="text-xs text-olive/70 mt-2 space-y-1 list-disc list-inside">
                            <li><b>1 hari = 1 mud</b> ≈ 0,75 kg beras, atau</li>
                            <li><b>1 porsi makan</b> lengkap dengan lauk.</li>
                        </ul>
                    </div>
                    <div class="bg-olive text-white rounded-xl p-4">
                        <div class="text-xs text-cream/80">CONTOH</div>
                        <div class="font-bold mt-1">Tinggalkan 10 hari × harga 1 porsi</div>
                        <div class="text-cream/80 text-xs mt-1">Total sesuai harga pasar setempat.</div>
                    </div>
                </div>
            </div>

            {{-- 8 Asnaf --}}
            <div id="asnaf" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">5</span> 8 Asnaf Penerima Zakat</h2>
                <p class="text-xs text-olive/60 mt-1">QS. At-Taubah: 60</p>
                <div class="mt-4 grid sm:grid-cols-2 gap-3 text-sm">
                    @php $asnafs = [
                        ['Fakir','Tidak punya harta & penghasilan, atau sangat tidak mencukupi.','fa-person-circle-question'],
                        ['Miskin','Punya penghasilan tapi tidak cukup untuk kebutuhan pokok.','fa-hand-holding-heart'],
                        ['Amil','Pengelola zakat yang ditunjuk.','fa-people-group'],
                        ['Muallaf','Yang dijinakkan hatinya.','fa-heart'],
                        ['Riqab','Memerdekakan dari jeratan perbudakan.','fa-link-slash'],
                        ['Gharimin','Berhutang untuk kebutuhan pokok.','fa-scale-balanced'],
                        ['Fisabilillah','Di jalan Allah (dakwah, kepentingan syar\'i).','fa-mosque'],
                        ['Ibnu Sabil','Musafir kehabisan bekal.','fa-person-walking-luggage'],
                    ]; @endphp
                    @foreach($asnafs as $i => $a)
                    <div class="bg-cream rounded-xl p-3 border border-cream-3 flex gap-3">
                        <div class="w-9 h-9 bg-white border border-cream-3 rounded-lg flex items-center justify-center text-olive flex-shrink-0"><i class="fa-solid {{ $a[2] }} text-xs"></i></div>
                        <div><div class="font-bold text-olive-dark text-sm">{{ $i+1 }}. {{ $a[0] }}</div><div class="text-xs text-olive/60 mt-0.5">{{ $a[1] }}</div></div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- FAQ --}}
            <div id="faq" class="bg-white rounded-[20px] border border-cream-3 p-5 lg:p-6">
                <h2 class="font-bold text-olive-dark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">?</span> Tanya Jawab</h2>
                <div class="mt-4 space-y-2">
                    @php $faqs = [
                        ['Bolehkah zakat fitrah dengan uang?','Boleh — dengan nilai setara 2,5 kg beras lokal.'],
                        ['Kapan batas akhir zakat fitrah?','Sebelum shalat Id. Jika terlewat, tetap wajib tapi terhitung sedekah biasa.'],
                        ['Apakah zakat mal dipotong hutang?','Ya, hutang jatuh tempo boleh mengurangi harta kena zakat sebelum hitung nishab.'],
                        ['Fidyah boleh dicicil?','Boleh, diberikan harian atau sekaligus kepada fakir miskin.'],
                        ['Ke mana menyalurkan di Banjarbaru?','BAZNAS Kota, UPZ/masjid terdekat, atau warga dhuafa — lihat Direktori.'],
                    ]; @endphp
                    @foreach($faqs as $f)
                    <details class="bg-cream rounded-xl border border-cream-3 px-4 py-3 group">
                        <summary class="font-semibold text-olive-dark text-sm cursor-pointer list-none flex justify-between items-center">{{ $f[0] }} <i class="fa-solid fa-chevron-down text-xs text-olive/50 group-open:rotate-180 transition"></i></summary>
                        <p class="text-xs text-olive/70 mt-2 leading-relaxed">{{ $f[1] }}</p>
                    </details>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-olive rounded-[20px] p-5 text-white lg:sticky lg:top-[76px]">
                <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-lightbulb"></i></div>
                <div class="font-bold mt-3">Butuh Hitung Cepat?</div>
                <p class="text-xs text-cream/70 mt-1">Buka kalkulator untuk simulasi zakat fitrah dan mal.</p>
                <a href="{{ url('/kalkulator') }}" class="mt-4 block text-center bg-cream text-olive-dark font-bold py-2.5 rounded-full text-sm hover:bg-white transition">Buka Kalkulator <i class="fa-solid fa-arrow-right ml-1"></i></a>
                <a href="{{ url('/direktori') }}" class="mt-2 block text-center bg-white/10 text-white font-semibold py-2.5 rounded-full text-sm hover:bg-white/15 transition border border-white/20">Lihat Peta Penyaluran</a>
            </div>
            <div class="bg-white rounded-[20px] border border-cream-3 p-4">
                <div class="font-bold text-olive-dark text-sm">Rujukan</div>
                <ul class="text-xs text-olive/60 mt-2 space-y-1 list-disc list-inside">
                    <li>Al-Qur'an &amp; Hadis</li>
                    <li>Fatwa MUI &amp; BAZNAS RI</li>
                    <li>Kitab Fiqh Zakat — Yusuf Qaradawi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection