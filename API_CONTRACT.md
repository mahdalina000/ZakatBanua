# Kontrak API ZakatBanua

File kontrak ada di **`openapi.yaml`** (OpenAPI 3.0.3) di root repository ini.
Ini adalah **Single Source of Truth** - semua perubahan API harus lewat PR yang mengubah file ini dulu (Design-First).

## Cara Kerja (GitHub sebagai Kontrak)

1. **Buat branch baru** untuk perubahan API:
   ```bash
   git checkout -b feat/kontrak-lokasi
   ```
2. **Edit `openapi.yaml`** (pakai VS Code + extension `42Crunch.vscode-openapi` atau https://editor.swagger.io)
3. **Validasi lokal sebelum push:**
   ```bash
   npx @redocly/cli lint openapi.yaml
   npx @apidevtools/swagger-cli validate openapi.yaml
   ```
4. **Push & buat Pull Request** ke `main`:
   ```bash
   git add openapi.yaml
   git commit -m "feat(api): tambah endpoint locations filter"
   git push -u origin feat/kontrak-lokasi
   ```
   Workflow `Validate API Contract` otomatis mengecek validitas OpenAPI. Jika gagal, PR tidak bisa di-merge.
5. **Review & Merge** -> setelah merge, buat tag versi:
   ```bash
   git tag v1.1.0
   git push origin v1.1.0
   ```
   Ikuti SemVer: `MAJOR` (breaking), `MINOR` (endpoint baru), `PATCH` (fix deskripsi/example).

## Menjalankan Mock Server (Frontend bisa coding tanpa backend)

```bash
# install prism sekali
npm install -g @stoplight/prism-cli

# jalankan mock
npx prism mock openapi.yaml --port 4010

# CATATAN: Prism memakai path dari spec, BUKAN prefix servers (/api).
# Jadi panggil tanpa /api:
curl http://localhost:4010/beras-price
curl -X POST http://localhost:4010/kalkulator/zakat-fitrah -H "Content-Type: application/json" -d '{"jumlah_jiwa":4}'
curl 'http://localhost:4010/locations?type=upz&per_page=2'
```

## Generate Dokumentasi Lokal

```bash
npx @redocly/cli preview-docs openapi.yaml
# atau build statis (HTML mandiri)
npx @redocly/cli build-docs openapi.yaml -o docs/index.html
```

## Generate Code / Contract Testing

- **Laravel:** cek kesesuaian implementasi dengan `schemathesis` atau `spectator` (https://github.com/hotmeteor/spectator)
- **Generate client:** `npx @openapitools/openapi-generator-cli generate -i openapi.yaml -g typescript-axios -o ./frontend/src/api`

## Aturan Kontrak

- Jangan ubah field tanpa bump versi MINOR/MAJOR.
- Field baru harus optional / nullable agar tidak breaking.
- Semua response error wajib pakai schema `ErrorResponse`.
- Pagination wajib pakai `PaginatedResponse`.

## Endpoint yang Dikontrak

- **Auth:** `POST /auth/register`, `/auth/login`, `/auth/logout`, `GET /auth/me`
- **Kalkulator:** `POST /kalkulator/zakat-fitrah`, `/kalkulator/zakat-mal`
- **Harga Beras:** `GET /beras-price`, `PUT /beras-price` (admin, bearerAuth)
- **Direktori:** `GET/POST /locations`, `GET/PUT/DELETE /locations/{id}`

> Status: seluruh endpoint di atas **sudah diimplementasikan di Back-end** dan sudah
> di-merge ke `main` (PR #1, commit `8c9f6fe`). Lihat `docs/API_ENDPOINTS.md` untuk
> contoh request/response siap pakai oleh Front-end.
