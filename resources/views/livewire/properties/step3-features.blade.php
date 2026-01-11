   <div class="row step3-features">
      <div class="col-12 mb-3">
         <p class="fs-6 fw-semibold text-start mb-1">
            Property Features <span class="text-danger">*</span>
         </p>
         <small class="text-muted">
            These are the house rules that tenants must follow while staying at the property.
            Please review them carefully before submitting your listing.
         </small>
      </div>

      <div class="col-12">
         @error('propertyFeatures')
         <div class="alert alert-danger d-flex align-items-center">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ $message }}
         </div>
         @enderror
      </div>

      <div class="col-12">
         <div x-data="{ selected: @entangle('propertyFeatures') }" class="row justify-content-start g-2 mb-3">

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
                                 selected.push('{{ $key }}')
                              }"
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