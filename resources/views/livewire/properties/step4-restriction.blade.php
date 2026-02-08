<div class="row step4-restrictions">
   <div class="col-12 mb-3">
      <p class="fs-6 fw-semibold text-start mb-1">
         Property Restrictions <span class="text-danger">*</span>
      </p>
      <small class="text-muted">
         These are the house rules that tenants must follow while staying at the property.
         Please review them carefully before submitting your listing.
      </small>
   </div>

   <div class="col-12">
      @error('propertyRestrictions')
      <div class="alert alert-danger d-flex align-items-center">
         <small>
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ $message }}
         </small>
      </div>
      @enderror
   </div>

   <div class="col-12">
      <!-- Alpine for instant UI, wire:model for sync -->
      <div
         x-data="{ selected: $wire.entangle('propertyRestrictions').live }"
         class="row justify-content-start g-2 mb-2">

         @foreach($propertyRestrictionIcons as $key => $icon)
         @php
         $colorClass = 'bg-secondary';
         $borderColorClass = str_replace('bg-', 'border-', $colorClass);
         @endphp

         <div class="col-auto" wire:key="property-restrictions-{{ $key }}">
            <button
               type="button"
               @click="
                  if(selected.includes('{{ $key }}')){
                     selected = selected.filter(f => f !== '{{ $key }}')
                  } else {
                     selected = [...selected, '{{ $key }}']
                  }
               "
               :class="selected.includes('{{ $key }}')
                  ? '{{ $colorClass }} text-white {{ $borderColorClass }} shadow-sm'
                  : 'bg-white text-dark {{ $borderColorClass }} shadow-sm'"
               class="d-flex flex-column align-items-center justify-content-center text-center border rounded restriction-box">

               <!-- Icon -->
               <i class="{{ $icon }} restriction-icon"
                  :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-{{ str_replace('bg-', '', $colorClass) }}'"></i>

               <!-- Restrictions Label -->
               <span class="fw-medium restriction-label"
                  :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-dark'">
                  {{ $key }}
               </span>
            </button>
         </div>
         @endforeach
      </div>
   </div>
</div>