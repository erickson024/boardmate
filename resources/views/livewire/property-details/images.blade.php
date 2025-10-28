<div class="container-fluid">
    @if(!empty($images))
        <div id="propertyCarousel" class="carousel slide  shadow-sm overflow-hidden" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($images as $index => $img)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $img) }}" 
                             class="d-block w-100" 
                             style="height: 400px; object-fit: cover;" 
                             alt="Property Image {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    @else
        <p class="text-muted">No images available for this property.</p>
    @endif
</div>
