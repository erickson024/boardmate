//if the user use back in browser
(function() {
    const propertyRegistration = document.querySelector(".property-registration");
    if (!propertyRegistration) return;
    
    let navigationAttempted = false;

    if (!window.location.hash) {
        window.location.hash = 'registration';
    }

    window.addEventListener('hashchange', function() {
        if (!navigationAttempted) {
            window.location.hash = 'registration';

            const modal = new bootstrap.Modal(document.getElementById('exitConfirmation'));
            modal.show();
        }
    });

    Livewire.on('exitRegistration', () => {
        navigationAttempted = true;
        
        // Trigger a custom event that other components can listen to
        window.dispatchEvent(new CustomEvent('draft-status-updated'));
    });

    document.addEventListener('livewire:navigating', () => {
        navigationAttempted = true;
    });
})();