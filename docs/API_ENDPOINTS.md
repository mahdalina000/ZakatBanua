# Cheatsheet Endpoint API — ZakatBanua

Dokumen ini adalah **panduan cepat** untuk Front-end (Kiel) memakai API yang sudah jadi.
Sumber kebenaran tetap **`openapi.yaml`**; dokumen ini hanya ringkasan + contoh konkret.

- **Base URL (lokal Laradock):** `http://zakat-banua.test/api`
- **Auth:** **Sanctum token (Bearer)**. Ambil token dari `/auth/login` atau `/auth/register`,
  lalu kirim header `Authorization: Bearer <token>`.
- **Format:** semua body & respons JSON (`Accept: application/json`, `Content-Type: application/json`).
- **Error standar:** `{"message": "..."}` (+ `errors` untuk 422).

---

## 1. Auth

### `POST /auth/register`
Body:
```json
{ "name": "Budi", "email": "budi@contoh.test", "password": "password123", "password_confirmation": "password123" }
```
Respons `201`:
```json
{ "message": "Registrasi berhasil", "token": "<token>", "user": { "id": 5, "name": "Budi", "email": "budi@contoh.test", "role": "user", "role_label": "Pengguna", "is_active": true } }
```

### `POST /auth/login`
Body: `{ "email": "...", "password": "..." }`
Respons `200`: sama seperti register (`message`, `token`, `user`). Menolak akun nonaktif / password salah → `422`.

### `GET /auth/me`  *(butuh token)*
Respons `200`: `{ "data": { ...user... } }`

### `POST /auth/logout`  *(butuh token)*
Respons `200`: `{ "message": "Logout berhasil" }` — token yang dipakai langsung dihapus.

---

## 2. Kalkulator (publik, tanpa token)

### `POST /kalkulator/zakat-fitrah`
Body:
```json
{ "jumlah_jiwa": 4, "harga_beras_override": 16000 }
```
`harga_beras_override` **opsional** — kalau kosong, harga diambil dari data beras terkini, atau default.
Respons `200`:
```json
{ "data": { "jumlah_jiwa": 4, "beras_kg": 10, "harga_beras_per_kg": 16000, "harga_beras_sumber": "database", "total_rupiah": 160000 } }
```

### `POST /kalkulator/zakat-mal`
Body:
```json
{ "total_harta": 100000000, "harga_emas_per_gram": 1100000 }
```
`harga_emas_per_gram` **opsional** (default 1.100.000).
Respons `200`:
```json
{ "data": { "total_harta": 100000000, "nishab": 93500000, "harga_emas_per_gram": 1100000, "wajib_zakat": true, "zakat": 2500000, "persentase": 2.5 } }
```

---

## 3. Harga Beras

### `GET /beras-price`  (publik)
Respons `200`: `{ "data": { "id": 2, "price": 17000, "note": "...", "updated_by": 2, "created_at": "...", "updated_at": "..." } }`
Kosong → `404` `{"message":"Data tidak ditemukan."}`.

### `PUT /beras-price`  *(butuh token + role admin)*
Body: `{ "price": 17000, "note": "naik" }` — `price` wajib, minimal 1000.
Respons `200`: `{ "message": "Harga beras diperbarui", "data": { ... } }`.
Setiap perubahan **menambah record baru** (harga terkini = yang terbaru). Non-admin → `403`.

---

## 4. Direktori Lokasi

### `GET /locations`  (publik)
Query opsional: `?type=upz|baznas|warga`, `?is_active=true`, `?search=masjid`, `?per_page=15`, `?page=1`.
Respons `200`: `{ "data": [ ... ], "meta": { "current_page", "per_page", "total", "last_page" }, "links": { "first","last","prev","next" } }`

### `GET /locations/{id}`  (publik)
Respons `200`: `{ "data": { ...location... } }` — tidak ada → `404`.

### `POST /locations`  *(butuh token + role admin)*
Body (name, address, type wajib):
```json
{ "name": "Masjid Raya An-Nur", "address": "Jl. Pahlawan No.1", "kelurahan": "Kuala", "kecamatan": "Banjarmasin Utara", "latitude": -3.31, "longitude": 114.59, "type": "upz", "phone": "081234567890", "opening_hours": "08:00-17:00" }
```
`type` ∈ `baznas | upz | warga`. Respons `201`: `{ "message": "...", "data": { ..., "type_label": "UPZ / Masjid" } }`.

### `PUT /locations/{id}`  *(butuh token + role admin)*
Body sama seperti create (name, address, type wajib). Respons `200`.

### `DELETE /locations/{id}`  *(butuh token + role admin)*
Respons `200`: `{ "message": "Lokasi dihapus" }`.

---

## Catatan untuk Front-end

- **Opsional:** `latitude`/`longitude` di respons dikirim sebagai **string** (mis. `"-3.31"`),
  sedangkan saat mengirim body gunakan **number**. Selalu cast saat dipakai di JS.
- **Pagination:** gunakan `meta` & `links` untuk tombol "sebelumnya/berikutnya".
- Halaman yang butuh admin (`PUT /beras-price`, CRUD `/locations`) harus cek `user.role`
  dari `/auth/me` — hanya `super_admin`, `admin_baznas`, `admin_upz`, `admin` yang boleh.
- Cek kode status: `200/201` sukses, `401` belum login, `403` bukan admin, `404` data tidak ada,
  `422` validasi gagal (baca `errors`).

---

*Terakhir diselaraskan dengan `openapi.yaml` (OpenAPI 3.0.3) — repo ZakatBanua.*
