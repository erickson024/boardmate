<div class="row vh-100 d-flex align-items-center mt-4">
    <div class="col-12 col-md-6">
        <div class="d-flex flex-row mb-3">
            <button
                type="button"
                class="btn btn-dark me-2"
                wire:click="backHome">
                <i class="bi bi-arrow-bar-left"></i>
            </button>
            <div class="">
                <p class="fw-semibold fs-4 mb-0">{{ $property->propertyName }}</p>
                <div class="d-flex align-items-center text-muted mt-0">
                    <small>
                        <span>{{ $property->address }}</span>
                    </small>
                </div>
            </div>
        </div>

        <p class="lh-lg"><small>{{ $property->propertyDescription }}</small></p>

        <div class="">
            <a href="{{route('tenant.inquiry.create', $property)}}" class="btn btn-sm btn-dark" wire:navigate>
                <small class="fw-semibold">Send Inquire</small>
            </a>

            <button class="btn btn-sm btn-outline-dark">
                <small class="fw-semibold">Save in list</small>
            </button>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="row g-2">
            @php
            $images = is_array($property->images) ? $property->images : [];
            @endphp

            @if(!empty($images))
            {{-- Main Image --}}
            <div class="col-12 col-md-5">
                <img src="{{ asset('storage/' . $images[0]) }}"
                    class="w-100 rounded-3"
                    style="height: 350px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';"
                    alt="{{ $property->propertyName }}"
                    data-bs-toggle="modal"
                    data-bs-target="#imageModal"
                    onclick="showImage('{{ asset('storage/' . $images[0]) }}', 0, {{ count($images) }})">
            </div>

            {{-- Side Images --}}
            <div class="col-12 col-md-7">
                <div class="row g-2">
                    @foreach(array_slice($images, 1, 4) as $index => $image)
                    <div class="col-6">
                        <img src="{{ asset('storage/' . $image) }}"
                            class="w-100 rounded-3"
                            style="height: 169px; object-fit: cover; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease;"
                            onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 8px 16px rgba(0,0,0,0.2)';"
                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';"
                            alt="{{ $property->propertyName }}"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                            onclick="showImage('{{ asset('storage/' . $image) }}', {{ $index + 1 }}, {{ count($images) }})">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>