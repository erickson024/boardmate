// Only run if we're on the property details page
const propertyDetailsPage = document.querySelector('.property-details');

if (propertyDetailsPage) {
    let currentSection = 0;
    let isScrolling = false;
    const maxSection = 5;

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

    propertyDetailsPage.addEventListener(
        "wheel",
        (e) => {
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
        },
        { passive: false },
    );
}