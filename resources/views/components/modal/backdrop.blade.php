<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      {{-- Header --}}
      <div class="modal-header">
        <h5 class="modal-title fs-6" id="{{ $id }}Label">{{ $title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Body --}}
      <div class="modal-body">
        {{ $slot }}
      </div>

      {{-- Footer (optional) --}}
      @isset($footer)
      <div class="modal-footer">
        {{ $footer }}
      </div>
      @endisset

    </div>
  </div>
</div>
