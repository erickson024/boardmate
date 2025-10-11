    @php
    $steps = [
        1 => ['label' => 'Personal Info', 'description' => 'Fill in your personal details to get started.'],
        2 => ['label' => 'Set Up Your Password', 'description' => 'Choose a secure password that meets our safety standards.'],
        3 => ['label' => 'Email & Terms', 'description' => 'Provide your email address and review the terms and conditions carefully.'],
    ];
    @endphp

    <div class="d-flex flex-column gap-5 " 
        @foreach ($steps as $step => $data)
            <div class="d-flex gap-3 position-relative">

                {{-- Step line connector --}}
                @if ($step < $totalSteps)
                    <div style="
                            position: absolute;
                            left: 12px;
                            top: 25px;
                            height: 140%;
                            width: 1px;
                            background-color: {{ $currentStep > $step ? '#fff' : '#999' }};
                            z-profile: 0;
                            transition: background-color 0.3    s ease;
                        " >
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
