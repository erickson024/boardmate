<div wire:ignore id="boardmateToast" class="toast mb-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="z-index:1100;">
    <div class="toast-header">
        <span class="me-auto fw-semibold small">Admin Boardmate</span>
        <small id="toastTime">11 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <p id="toastTitle" class="small fw-semibold mb-0">BoardMate</p>
        <span id="toastMessage" class="small mt-0">Notification</span>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('toast', (data) => {
            const toastEl = document.getElementById('boardmateToast');
            document.getElementById('toastTitle').textContent = data.title ?? 'BoardMate';
            document.getElementById('toastMessage').textContent = data.message ?? '';
            document.getElementById('toastTime').textContent = data.time ?? 'just now';
            toastEl.className = 'toast fade show align-items-center text-bg-dark border-0 position-fixed bottom-0 end-0';
            new bootstrap.Toast(toastEl, {
                delay: 4000
            }).show();
        });
    });
</script>