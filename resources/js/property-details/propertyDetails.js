// Global state for property details scroll
let currentSection = 0;
let isScrolling = false;
const maxSection = 5;

function resetScroll() {
    currentSection = 0;
    const wrapper = document.getElementById("scrollWrapper");
    if (wrapper) {
        wrapper.style.transform = `translateY(0)`;
    }
}

function scrollToSection(index) {
    if (index < 0 || index > maxSection || isScrolling) return;

    isScrolling = true;
    currentSection = index;

    const wrapper = document.getElementById("scrollWrapper");
    if (wrapper) {
        wrapper.style.transform = `translateY(-${currentSection * 100}vh)`;
    }

    setTimeout(() => (isScrolling = false), 800);
}

function initPropertyDetails() {
    const propertyDetailsPage = document.querySelector('.property-details');
    
    if (!propertyDetailsPage) return;

    resetScroll();

    // Remove old listener if exists
    propertyDetailsPage.removeEventListener('wheel', handleWheel);

    // Attach wheel event listener
    propertyDetailsPage.addEventListener(
        "wheel",
        handleWheel,
        { passive: false }
    );
}

function handleWheel(e) {
    // Check if image modal is open
    const imageModal = document.getElementById("imageModal");
    if (imageModal && imageModal.classList.contains('show')) {
        // Allow normal scrolling when modal is open
        return;
    }

    // Check if the user is hovering over the map
    const mapElement = document.getElementById("map");
    if (mapElement) {
        const rect = mapElement.getBoundingClientRect();
        const isOverMap = (
            e.clientX >= rect.left &&
            e.clientX <= rect.right &&
            e.clientY >= rect.top &&
            e.clientY <= rect.bottom
        );

        // If cursor is over the map, don't interfere with map controls
        if (isOverMap) {
            return;
        }
    }

    e.preventDefault();
    e.stopPropagation();

    if (e.deltaY > 0) {
        scrollToSection(currentSection + 1);
    } else {
        scrollToSection(currentSection - 1);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initPropertyDetails);

// Re-initialize when Livewire navigates
document.addEventListener('livewire:navigated', initPropertyDetails);