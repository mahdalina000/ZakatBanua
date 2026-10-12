import api from './api.js';
import { initAbstractBg, autoInitAbstractBg } from './abstract-bg.js';

// Ekspos API client ke global agar bisa dipakai di inline script Blade
window.ZakatApi = api;

// Latar abstrak dinamis
window.initAbstractBg = initAbstractBg;
window.autoInitAbstractBg = autoInitAbstractBg;

// Konfigurasi alamat API — memakai API asli (Laravel) di domain yang sama.
// Bisa diubah lewat VITE_API_URL atau window.ZAKAT_API_URL bila perlu.
const DEFAULT_API = (location.origin || 'http://zakat-banua.test') + '/api';
window.ZAKAT_API_URL = window.ZAKAT_API_URL || DEFAULT_API;

export { api };