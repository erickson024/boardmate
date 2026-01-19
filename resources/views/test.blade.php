<div class="bg-white ">

    {{-- Main Search Row --}}
    <div style="">
        <div class="row g-1 align-items-end ">
            {{-- Property Name --}}
            <div class="col-6 col-lg-3">
                <div class="filter-item">
                    <label for="propertyName" class="filter-label">
                        <i class="bi bi-search"></i>
                        Property Name
                    </label>
                    <input
                        type="text"

                        id="propertyName"
                        class="filter-input"
                        placeholder="Search properties...">
                </div>
            </div>



            {{-- Address --}}
            <div class="col-12 col-lg-3">
                <div class="filter-item">
                    <label for="address" class="filter-label">
                        <i class="bi bi-geo-alt"></i>
                        Address
                    </label>
                    <input
                        type="text"
                        id="address"
                        class="filter-input"
                        placeholder="City, area...">
                </div>
            </div>

            {{-- Action Button --}}
            <div class="col-12 col-lg-3 mb-3">
                <button type="button" class="btn btn-sm btn-outline-secondary fw-semibold"><small>Clear</small></button>
                <button type="button" class="btn btn-sm btn-dark fw-semibold"><small>Search</small></button>
            </div>
        </div>
    </div>

    {{-- Filter Chips Row --}}
    <div class="mb-3">
        <div class="d-flex gap-2">



        </div>
    </div>
        </div>