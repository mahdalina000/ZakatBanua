// ============================================================
// API Client — Zakat Banua (Gaya B: API + JavaScript)
// ------------------------------------------------------------
// Sumber data:
//   - Mock server  : http://localhost:4010   (dari openapi.yaml, Prism)
//   - Back-end asli: http://zakat-banua.test/api (nanti)
// Cukup ubah API_BASE_URL saat back-end asli siap.
// ============================================================

const API_BASE_URL = window.ZAKAT_API_URL || 'http://localhost:4010';

/**
 * Panggilan dasar ke API. Mengembalikan JSON.
 */
async function apiFetch(path, { method = 'GET', body = null, token = null } = {}) {
    const headers = { 'Accept': 'application/json' };
    if (body) headers['Content-Type'] = 'application/json';
    if (token) headers['Authorization'] = `Bearer ${token}`;

    const res = await fetch(`${API_BASE_URL}${path}`, {
        method,
        headers,
        body: body ? JSON.stringify(body) : undefined,
    });

    const text = await res.text();
    let data = null;
    try { data = text ? JSON.parse(text) : null; } catch { data = { raw: text }; }

    if (!res.ok) {
        const err = new Error((data && (data.message || data.error)) || `HTTP ${res.status}`);
        err.status = res.status;
        err.data = data;
        throw err;
    }
    return data;
}

/* ---------- Endpoint sesuai openapi.yaml (kontrak Masidah) ---------- */

export const api = {
    // Auth
    login: (email, password) => apiFetch('/auth/login', { method: 'POST', body: { email, password } }),
    register: (payload) => apiFetch('/auth/register', { method: 'POST', body: payload }),
    logout: (token) => apiFetch('/auth/logout', { method: 'POST', token }),
    me: (token) => apiFetch('/auth/me', { token }),

    // Harga beras
    berasPrice: () => apiFetch('/beras-price'),

    // Direktori lokasi
    locations: (params = {}) => {
        const q = new URLSearchParams(params).toString();
        return apiFetch('/locations' + (q ? `?${q}` : ''));
    },
    location: (id) => apiFetch(`/locations/${id}`),

    // Kalkulator (dihitung di server)
    zakatFitrah: (jumlah_jiwa) =>
        apiFetch('/kalkulator/zakat-fitrah', { method: 'POST', body: { jumlah_jiwa } }),
    zakatMal: (total_harta) =>
        apiFetch('/kalkulator/zakat-mal', { method: 'POST', body: { total_harta } }),
};

export default api;
