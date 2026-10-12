# Panduan Kontribusi — Zakat Banua

Dokumen ini menjelaskan **pembagian kerja**, **alur Git**, dan **cara setup** project agar kolaborasi
antara Front-end dan Back-end berjalan tanpa bentrok.

---

## 1. Tim & Pembagian Peran

| Peran | Penanggung Jawab | Folder yang dikelola |
|---|---|---|
| **Front-end** | Kiel | `resources/views/` |
| **Back-end** | Siti Masidah | `app/`, `database/`, `routes/`, `bootstrap/` |

> **Aturan mutlak:** jangan mengedit file milik peran lain tanpa koordinasi lebih dulu.
> Butuh perubahan lintas-area? **Kabari pasangan**, jangan langsung timpa.

Karena Blade bersifat *server-rendered*, halaman baru hanya tampil bila ada **route** (wilayah Back-end)
yang mengembalikannya.

---

## 2. Alur Git

```
main              → versi stabil (untuk presentasi)
 ├─ feat/frontend → kerjaan Kiel
 └─ feat/backend  → kerjaan Masidah
```

**Alur kerja harian:**

```bash
# 1. Ambil branch kerja yang sesuai peran
git checkout feat/frontend     # Kiel
git checkout feat/backend      # Masidah

# 2. Selalu tarik perubahan terbaru sebelum mulai
git pull origin <branch-kerja>

# 3. Kerjakan, lalu commit kecil & sering
git add .
git commit -m "feat: tambah halaman panduan zakat"

# 4. Push ke GitHub
git push origin <branch-kerja>
```

**Merge ke `main`** hanya dilakukan bila fitur **sudah jalan & diuji**.
Disarankan lewat **Pull Request** agar bisa ditinjau pasangan.

---

## 3. Setup Project di Komputer Baru

Prasyarat: PHP 8.3+, Composer, Node.js (opsional untuk Vite).

```bash
# 1. Clone repository
git clone https://github.com/mahdalina000/ZakatBanua.git
cd ZakatBanua

# 2. Salin konfigurasi environment
cp .env.example .env

# 3. Install dependency
composer install

# 4. Generate application key
php artisan key:generate

# 5. Siapkan database (sesuaikan .env bila perlu), lalu migrasi
php artisan migrate --seed

# 6. (Opsional) jalankan server lokal
php artisan serve
```

> Lingkungan pengembangan tim memakai **Laradock** (Docker).
> Domain lokal: `http://zakat-banua.test`.

---

## 4. Kontrak Data (WAJIB disepakati bersama)

Blade memakai **nama variabel** & **nama route** yang ditentukan Back-end.
Front-end memakai nama tersebut persis. **Jangan ubah nama tanpa memberi tahu pasangan.**

**Nama route yang dipakai Front-end:**

| Nama route | Halaman |
|---|---|
| `dashboard` | Dashboard (redirect sesuai role) |
| `login`, `register`, `logout` | Autentikasi |
| `admin.locations.index` | Daftar lokasi admin |
| `admin.beras.index` | Pengelolaan harga beras |
| `super.users`, `super.locations`, `super.activity` | Halaman Super Admin |

**Contoh variabel Controller → View:** `$spots`, `$hargaBeras`, `$locations`, `$users`, `$counts`,
`$current`, `$history`.

**Pola kerja Front-end sementara (sebelum Back-end siap):**
Front-end boleh memakai **data contoh hardcode** + **route sementara** di `routes/web.php`
yang **wajib ditandai** komentar `// TODO(backend): ganti dengan route asli`.

---

## 5. Standar Penulisan Commit

Gunakan format `tipe: deskripsi singkat`:

| Tipe | Untuk |
|---|---|
| `feat` | Fitur baru |
| `fix` | Perbaikan bug |
| `style` | Perubahan tampilan/CSS tanpa mengubah logika |
| `refactor` | Perapian kode tanpa mengubah perilaku |
| `docs` | Dokumentasi |
| `chore` | Konfigurasi, dependency, dll |

Contoh: `feat: halaman direktori peta dengan filter warna`, `fix: header tertutup peta saat scroll`.

---

## 6. Checklist Sebelum Push

- [ ] Kode sudah diuji di browser (tidak ada error 500).
- [ ] Tidak meng-commit file `.env` (berisi rahasia) — cek `git status`.
- [ ] Tidak mengubah file milik peran lain tanpa izin.
- [ ] Commit dengan pesan yang jelas.

---

© 2026 Zakat Banua — Amanah, Transparan, Berkah
