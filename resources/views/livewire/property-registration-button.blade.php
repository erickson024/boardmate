<a href="{{route('property-registration')}}"
    class="btn btn-sm btn-dark shadow-sm fw-semibold rounded-5 px-3 position-relative"
    wire:navigate>
    <small>Properties <i class="bi bi-plus-lg"></i></small>

    @if($hasDraft)
    <span class="position-absolute top-0 start-25 translate-middle badge rounded-pill bg-warning text-dark shadow-sm" 
          style="font-size: 0.6rem; padding: 0.35em 0.5em;"
          title="You have a draft in progress">
        <i class="bi bi-clock-fill"></i>
    </span>
    @endif
</a>

<script>
    // Listen for draft status updates
    window.addEventListener('draft-status-updated', () => {
        @this.call('checkDraft');
    });
    
    // Also check on Livewire navigation
    document.addEventListener('livewire:navigated', () => {
        @this.call('checkDraft');
    });
</script>