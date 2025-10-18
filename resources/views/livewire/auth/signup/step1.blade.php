<div>
    <span class="fs-6 fw-medium">Personal Information</span>

    <form autocomplete="off">
        <div class="row mt-3 gx-3">
            <div class="col-6">
                <div class="form-floating">
                    <input
                        type="text"
                        wire:model="firstname"
                        id="firstname"
                        name="firstname"
                        class="form-control border-1 shadow-sm"
                        placeholder="firstname"
                        autocomplete="new-password"
                        required>
                    <label for="firstname" class="fw-medium"><small>Firstname</small></label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-floating">
                    <input
                        type="text"
                        wire:model="lastname"
                        id="lastname"
                        name="lastname"
                        class="form-control border-1 shadow-sm"
                        placeholder="lastname"
                        autocomplete="new-password"
                        required>
                    <label for="lastname" class="fw-medium"><small>Lastname</small></label>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="form-floating">
                    <input
                        type="text"
                        wire:model="address"
                        id="address"
                        name="address"
                        class="form-control border-1 shadow-sm"
                        placeholder="address"
                        autocomplete="off"
                        required>
                    <label for="address" class="fw-medium"><small>Current Address</small></label>
                </div>
            </div>
        </div>
    </form>
</div>
