import api from './api.js';
import { initAbstractBg, autoInitAbstractBg } from './abstract-bg.js';

// Ekspos API client ke global agar bisa dipakai di inline script Blade
window.ZakatApi = api;

// Latar abstrak dinamis
window.initAbstractBg = initAbstractBg;
window.autoInitAbstractBg = autoInitAbstractBg;

// Konfigurasi alamat API (mudah diganti saat back-end asli siap)
window.ZAKAT_API_URL = window.ZAKAT_API_URL || 'http://localhost:4010';

export { api };