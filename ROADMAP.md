# Peta Perkembangan (Roadmap) — Zakat Banua

Dokumen ini mencatat **status terkini**, **target presentasi**, dan **rencana menuju 100%**.
Ditujukan untuk tim (Kiel — Front-end, Siti Masidah — Back-end) dan Pemko Banjarbaru.

---

## 1. Ringkasan Status

| Bagian | Status | Keterangan |
|---|---|---|
| Pondasi project (Laravel + Laradock + domain) | ✅ 100% | `zakat-banua.test` berjalan |
| Kontrak API (OpenAPI 3.0) | ✅ 100% | `openapi.yaml`, mock server aktif |
| Front-end halaman publik | ✅ 100% | Selamat datang, beranda, kalkulator, direktori, panduan |
| Back-end API asli | 🔄 berjalan | Mock → implementasi nyata |
| Login & dashboard 4 role | ⬜ belum | Direncanakan F1 |
| Admin CRUD & statistik | ⬜ belum | Direncanakan F2 |

**Progres keseluruhan saat ini: ± 25–30%.**

---

## 2. Target Presentasi — Rabu

Target realistis: **70–80%** dengan fitur berikut **tuntas & bisa didemokan**:

- [ ] Login + redirect sesuai role
- [ ] Dashboard 4 role (Super Admin, Admin BAZNAS, Admin UPZ, User)
- [ ] API asli: auth, locations, beras-price, kalkulator
- [ ] Integrasi front-end ↔ back-end asli (bukan lagi mock)
- [ ] Data lokasi riil wilayah Banjarbaru
- [ ] Gladi demo + skenario cadangan (fallback bila API bermasalah)

**Diluar target Rabu (dijadikan roadmap):** riwayat perhitungan, ekspor laporan,
pembayaran online, notifikasi haul, manajemen mustahik, deploy produksi.

---

## 3. Peta Menuju 100%

| Fase | Cakupan | Estimasi | Target Progres |
|---|---|---|---|
| **F0 — Pondasi** | Project, RBAC, kontrak API, front publik | ✅ selesai | ± 30% |
| **F1 — MVP** | Login 4 role, dashboard, API asli (auth/lokasi/beras/kalkulator), integrasi, data Banjarbaru | 16–19 jam | **70–80%** |
| **F2 — Operasional** | CRUD lokasi penuh, kelola harga beras + riwayat, statistik & grafik lengkap | 8–10 jam | 85% |
| **F3 — Transaksi** | Riwayat perhitungan user, simpan/struk, ekspor laporan (PDF/Excel) | 10–12 jam | 92% |
| **F4 — Lanjutan** | Pembayaran online (QRIS/transfer), notifikasi & pengingat haul, manajemen mustahik | 15–20 jam | 97% |
| **F5 — Produksi** | Keamanan, backup, deploy ke server, dokumentasi, uji akhir | 12–15 jam | **100%** |

> Estimasi berdasarkan **kerja paralel 2 orang**. Total sisa ± 60–70 jam kerja setelah Rabu.

---

## 4. Rencana Sesi

**Sesi 1 — Senin siang (s/d 16.00)**
- Commit & push front-end ✅
- Back-end: migration + model + endpoint auth & locations
- Front-end: halaman login & daftar

**Sesi 2 — Senin malam (19.00–22.00)**
- Back-end: endpoint beras-price & kalkulator
- Front-end: dashboard 4 role (siap colok API)

**Selasa (pagi & malam)**
- Integrasi front ↔ API asli
- Admin CRUD lokasi & harga beras
- Statistik Super Admin
- Isi data lokasi riil Banjarbaru

**Rabu pagi (persiapan)**
- Uji seluruh alur, perbaiki bug
- Gladi demo (login tiap role → hitung zakat → buka peta)
- Siapkan fallback bila API bermasalah

---

## 5. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| API belum selesai saat presentasi | Front-end punya **fallback nilai contoh** — halaman tetap tampil |
| Data wilayah belum lengkap | Isi data prioritas (BAZNAS + beberapa masjid) lebih dulu |
| Waktu habis untuk fitur tambahan | Fokus pada daftar F1; sisanya masuk roadmap |
| Bentrok kode antar anggota | Kerja di branch terpisah (`feat/frontend`, `feat/backend`) |

---

## 6. Definisi "100%"

Aplikasi dinyatakan **selesai (100%)** bila:

1. Seluruh role dapat login & mendapat akses sesuai kewenangan.
2. Seluruh data (lokasi, harga beras) dikelola lewat aplikasi, bukan data statis.
3. Perhitungan zakat & fidyah akurat dan tercatat.
4. Masyarakat dapat melihat direktori & panduan dengan data riil.
5. Tersedia laporan bagi Super Admin.
6. Aplikasi ter-deploy, aman, dan didokumentasikan.

---

© 2026 Zakat Banua — Amanah, Transparan, Berkah