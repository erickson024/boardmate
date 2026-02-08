<a href="{{route('property-registration')}}"
    class="btn btn-sm btn-dark shadow-sm fw-semibold rounded-5 px-3 position-relative"
    wire:navigate>
    <small>Properties <i class="bi bi-plus-lg"></i></small>

    @if($hasDraft)
    <span class="position-absolute top-0 start-25 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.6rem;">
        <i class="bi bi-clock-fill"></i>
    </span>
    @endif
</a>