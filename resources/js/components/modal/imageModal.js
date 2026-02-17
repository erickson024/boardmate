(function () {
    const propertyImageModal = document.querySelector(".property-image-modal");
    if (!propertyImageModal) return;

    window.showImage = function (imageSrc) {
        console.log("showImage called with:", imageSrc);

        const modalImage = document.getElementById("modalImage");
        const imageLoader = document.getElementById("imageLoader");
        const closeBtn = document.getElementById("imageCloseBtn");

        // Show loader, hide image and close button
        if (imageLoader) imageLoader.style.display = "block";
        modalImage.style.opacity = "0";
        modalImage.classList.remove("loaded");
        closeBtn.classList.remove("show");

        // Preload image with smooth transition
        const img = new Image();
        img.onload = function () {
            modalImage.src = imageSrc;

            setTimeout(() => {
                modalImage.classList.add("loaded");
                if (imageLoader) imageLoader.style.display = "none";

                // Show close button after image loads
                setTimeout(() => {
                    closeBtn.classList.add("show");
                }, 200);
            }, 100);
        };

        img.onerror = function () {
            console.error("Failed to load image:", imageSrc);
            if (imageLoader) {
                imageLoader.innerHTML = `
                    <div class="text-white text-center p-4">
                        <i class="bi bi-exclamation-triangle-fill fs-1 mb-3 d-block"></i>
                        <p class="mb-0">Failed to load image</p>
                    </div>
                `;
            }
            // Show close button even on error
            closeBtn.classList.add("show");
        };

        img.src = imageSrc;
    };

    // Reset modal on close
    document
        .getElementById("imageModal")
        ?.addEventListener("hidden.bs.modal", function () {
            const modalImage = document.getElementById("modalImage");
            const imageLoader = document.getElementById("imageLoader");
            const closeBtn = document.getElementById("imageCloseBtn");

            modalImage.src = "";
            modalImage.style.opacity = "0";
            modalImage.classList.remove("loaded");
            closeBtn.classList.remove("show");

            if (imageLoader) {
                imageLoader.style.display = "block";
                imageLoader.innerHTML =
                    '<div class="spinner-border text-light" role="status" style="width: 3.5rem; height: 3.5rem; border-width: 4px;"><span class="visually-hidden">Loading...</span></div>';
            }
        });

    // Keyboard support (ESC to close)
    document.addEventListener("keydown", function (e) {
        const modal = document.getElementById("imageModal");
        if (modal && modal.classList.contains("show") && e.key === "Escape") {
            bootstrap.Modal.getInstance(modal)?.hide();
        }
    });
})();
