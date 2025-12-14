import 'bootstrap'; // Import Bootstrap JS
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('livewire:init', () => {
    Livewire.on('toast', ({ title, message, type }) => {
        const toastEl = document.getElementById('boardmateToast');
        if (!toastEl) return;

        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        toastTitle.textContent = title ?? 'BoardMate';
        toastMessage.textContent = message ?? '';

        // Reset classes and add type
        toastEl.className = 'toast align-items-center border-0';
        const bgMap = {
            success: 'text-bg-success',
            warning: 'text-bg-warning',
            danger: 'text-bg-danger',
            info: 'text-bg-info'
        };
        toastEl.classList.add(bgMap[type] ?? 'text-bg-dark');

        // Show toast
        new bootstrap.Toast(toastEl, { delay: 4000 }).show();
    });
});
