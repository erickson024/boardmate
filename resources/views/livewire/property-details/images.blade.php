<div>
    <div class="row mb-3">
        <div class="col-12">
            <p class="fw-semibold fs-4 mb-0">{{ $property->propertyName }}</p>
            <div class="d-flex align-items-center text-muted mt-0">
                <small>
                    <span>{{ $property->address }}</span>
                </small>
            </div>
        </div>
    </div>
    {{-- Property Images Gallery --}}
    <div class="row g-2 mb-3">
        @php
        $images = is_array($property->images) ? $property->images : [];
        @endphp

        @if(!empty($images))
        {{-- Main Image --}}
        <div class="col-12 col-md-5">
            <img src="{{ asset('storage/' . $images[0]) }}"
                class="w-100 rounded-3"
                style="height: 300px; object-fit: cover;"
                alt="{{ $property->propertyName }}">
        </div>

        {{-- Side Images --}}
        <div class="col-12 col-md-7">
            <div class="row g-2">
                @foreach(array_slice($images, 1, 4) as $index => $image)
                <div class="col-6">
                    <img src="{{ asset('storage/' . $image) }}"
                        class="w-100 rounded-3"
                        style="height: 145px; object-fit: cover;"
                        alt="{{ $property->propertyName }}">
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="col-12">
            <img src="{{ asset('images/no-image.jpg') }}"
                class="w-100 rounded-3"
                style="height: 400px; object-fit: cover;"
                alt="No Image Available">
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-6">
            <p class="text-dark fw-medium">₱{{ number_format($property->propertyCost, 2) }} monthly</p>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-end p-2 bg-dark rounded text-light">
                <span class="">
                    {{ $property->propertyType }}
                </span>
            </div>
        </div>
    </div>
</div>