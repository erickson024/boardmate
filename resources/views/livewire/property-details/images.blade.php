<div class="container-fluid px-0">
    @if(!empty($images))
    <div class="image-grid d-flex flex-wrap gap-3">
        @foreach($images as $index => $img)
        <div class="col-3">
            <img src="{{ asset('storage/' . $img) }}" 
                 alt="Property Image {{ $index + 1 }}" 
                 class="img-fluid rounded shadow-sm h-100">
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center p-5 rounded-4 bg-light">
        <i class="bi bi-image fs-1 text-secondary mb-3 d-block"></i>
        <p class="text-muted mb-0">No images available for this property.</p>
    </div>
    @endif

    <style>
        .image-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .grid-item {
            flex: 0 0 25%; /* 4 images per row */
            max-width: 25%;
        }

        .grid-item img {
            width: 100%;
            height: 90%; /* fixed height */
            object-fit: cover;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .grid-item img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .grid-item {
                flex: 0 0 50%; /* 2 images per row on mobile */
                max-width: 50%;
            }
        }

        @media (max-width: 480px) {
            .grid-item {
                flex: 0 0 100%; /* 1 image per row on small mobile */
                max-width: 100%;
            }
        }
    </style>
</div>
