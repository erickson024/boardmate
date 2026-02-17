(function () {
    const navigation = document.querySelector(".nav-section");
    if (!navigation) return;

    let navObserver = null;

    function updateNavHeight() {
        const navSection = document.querySelector(".nav-section");
        if (navSection) {
            document.documentElement.style.setProperty(
                "--nav-height",
                navSection.offsetHeight + "px",
            );
        }
    }

    function init() {
        const filterToggleBtn = document.getElementById("filterToggleBtn");
        const filterWrapper = document.getElementById("propertyFilterWrapper");
        const mainNavbar = document.getElementById("mainNavbar");
        const navSection = document.querySelector(".nav-section");

        if (navObserver) navObserver.disconnect();

        if (navSection) {
            navObserver = new ResizeObserver(updateNavHeight);
            navObserver.observe(navSection);
        }

        updateNavHeight();

        if (filterToggleBtn && filterWrapper) {
            const freshWrapper = filterWrapper.cloneNode(true);
            filterWrapper.replaceWith(freshWrapper);

            freshWrapper.addEventListener("shown.bs.collapse", function () {
                // Filter open = search is ON = dark button
                filterToggleBtn.className = filterToggleBtn.className
                    .replace("btn-light", "")
                    .replace("btn-outline-dark", "");
                filterToggleBtn.classList.add("btn-dark");
                filterToggleBtn.style.border = "";
                if (mainNavbar) mainNavbar.classList.remove("navbar-shadow");
            });

            freshWrapper.addEventListener("hidden.bs.collapse", function () {
                // Filter closed = search is OFF = white button with dark border
                filterToggleBtn.classList.remove("btn-dark");
                filterToggleBtn.classList.add("btn-light", "btn-outline-dark");
                filterToggleBtn.style.border = "";
                if (mainNavbar) mainNavbar.classList.add("navbar-shadow");
            });
        }
    }

    document.addEventListener("DOMContentLoaded", init);
    document.addEventListener("livewire:navigated", init);
})();
