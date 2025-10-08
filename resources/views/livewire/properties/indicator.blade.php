@php
$steps = [
    1 => ['label' => 'Basic Information', 'description' => 'Provide the key details about your property.'],
    2 => ['label' => 'Property Location', 'description' => 'Help tenants find your property by setting its exact location.'],
    3 => ['label' => 'Amenities & Feature', 'description' => 'Highlight the amenities and features tenants can enjoy.'],
    4 => ['label' => 'Property Photo', 'description' => 'Upload clear photos of your property.'],
   
];
@endphp

<div class="d-flex flex-column gap-3 " 
    @foreach ($steps as $step => $data)
        <div class="d-flex gap-3 position-relative">

            {{-- Step line connector --}}
            @if ($step < $totalSteps)
                <div style="
                        position: absolute;
                        left: 12px;
                        top: 25px;
                        height: 90%;
                        width: 1px;
                        background-color: {{ $currentStep > $step ? '#fff' : '#999' }};
                        z-index: 0;
                        transition: background-color 0.3    s ease;" >
        </div>
            @endif

            {{-- Step circle --}}
            <div
                class="rounded-circle d-flex align-items-center justify-content-center z-1  fw-semibold border-0"
                style="
                    width: 25px;
                    height: 25px;
                    min-width: 25px;
                    min-height: 25px;
                    background-color: {{ $currentStep >= $step ? '#ffffff' : '#f1f1f1' }};
                    color: {{ $currentStep >= $step ? '#000' : '#999' }};
                    border: 1px solid #ccc;
                    white-space: nowrap;
                    overflow: hidden;
                    text-align: center;
                ">
                {{ $step }}
            </div>

            {{-- Label and Description --}}
            <div class="mt-0">
                <p class="{{ $currentStep == $step ? 'text-light fw-semibold' : 'text-secondary' }}  fw-normal mb-0 lh-sm">
                    {{ $data['label'] }}
                </p>
                <p class="{{ $currentStep == $step ? 'text-light fw-normal' : 'text-secondary' }} text-break"
                   style="font-size: 11px;">
                    {{ $data['description'] }}
                </p>
            </div>

        </div>
    @endforeach
</div>
