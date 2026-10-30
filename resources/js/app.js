/**
 * SIMRS — app.js
 * Entry point JavaScript Laravel.
 *
 * Tend template JS utama diload langsung dari public/tend/assets/*.js
 * melalui tag <script> di layouts/app.blade.php.
 *
 * File ini untuk kode tambahan spesifik SIMRS.
 */

import './bootstrap';

// ── CSRF token di semua request Axios ────────────────────────────────────────
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// ── Helper global ─────────────────────────────────────────────────────────────

/**
 * Format tanggal Indonesia sederhana.
 * @param {string|Date} date
 * @returns {string}
 */
window.formatTanggal = (date) => {
    return new Intl.DateTimeFormat('id-ID', {
        day: '2-digit', month: 'long', year: 'numeric'
    }).format(new Date(date));
};

/**
 * Format jam Indonesia.
 * @param {string|Date} date
 * @returns {string}
 */
window.formatJam = (date) => {
    return new Intl.DateTimeFormat('id-ID', {
        hour: '2-digit', minute: '2-digit'
    }).format(new Date(date));
};
