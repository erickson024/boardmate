<div class="row step3-features">
   <div class="col-12 mb-3">
      <p class="fs-6 fw-semibold text-start mb-1">
         Property Features <span class="text-danger">*</span>
      </p>
      <small class="text-muted">
         Select the amenities and features available at your property.
         This helps tenants understand what makes your property unique.
      </small>
   </div>

   <div class="col-12">
      @error('propertyFeatures')
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
         x-data="{ selected: $wire.entangle('propertyFeatures').live }"
         class="row justify-content-start g-2 mb-3">

         @foreach($propertyFeatureIcons as $key => $icon)
         @php
         $colorClass = $featureColors[$key] ?? 'bg-secondary';
         $borderColorClass = str_replace('bg-', 'border-', $colorClass);
         @endphp

         <div class="col-auto" wire:key="property-feature-{{ $key }}">
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
               class="d-flex flex-column align-items-center justify-content-center text-center border rounded feature-box">

               <!-- Icon -->
               <i class="{{ $icon }} feature-icon"
                  :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-{{ str_replace('bg-', '', $colorClass) }}'"></i>

               <!-- Feature Label -->
               <span class="fw-medium feature-label"
                  :class="selected.includes('{{ $key }}') ? 'text-white' : 'text-dark'">
                  {{ $key }}
               </span>
            </button>
         </div>
         @endforeach
      </div>
   </div>
</div>