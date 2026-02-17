{{-- Image Zoom Modal - Clean with White Close Button --}}
<div class="property-image-modal">
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" wire:ignore.self data-bs-backdrop="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 95vw; margin: 1rem auto;">
            <div class="modal-content bg-transparent border-0 shadow-none">

                <div class="modal-body d-flex justify-content-center align-items-center position-relative p-0" style="height: 85vh; max-height: 85vh;">
                    {{-- Loading Spinner --}}
                    <div id="imageLoader" class="position-absolute" style="z-index: 1060;">
                        <div class="spinner-border text-light" role="status" style="width: 3.5rem; height: 3.5rem; border-width: 4px;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    {{-- Image Container with Close Button --}}
                    <div id="imageContainer" class="position-relative d-flex align-items-center justify-content-center" style="padding: 20px;">
                        {{-- Close Button - White with Dark Icon --}}
                        <button
                            type="button"
                            class="position-absolute shadow-lg"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            id="imageCloseBtn"
                            style="top: 10px;
                               right: 10px;
                               z-index: 1063; 
                               width: 44px; 
                               height: 44px; 
                               background: white;
                               border: none;
                               border-radius: 50%; 
                               padding: 0;
                               display: none;
                               align-items: center;
                               justify-content: center;
                               transition: all 0.3s ease;
                               cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#1f2937" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </button>

                        <img
                            id="modalImage"
                            src=""
                            alt="Zoomed Image"
                            class="img-fluid"
                            style="max-height: 80vh; 
                               max-width: 90vw; 
                               width: auto; 
                               object-fit: contain; 
                               opacity: 0; 
                               transition: opacity 0.4s ease-in-out; 
                               border-radius: 12px;
                               box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>