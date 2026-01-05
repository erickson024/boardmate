<div class="d-flex align-items-center mb-2">
    <div class="flex-grow-1">
        <div class="progress rounded" style="height: 3px;">
            <div class="progress-bar 
                        @if($strengthScore < 2) bg-danger 
                        @elseif($strengthScore < 4) bg-warning 
                        @else bg-success 
                        @endif"
                role="progressbar"
                style="width: {{ ($strengthScore / 5) * 100 }}%">
            </div>
        </div>
    </div>

    <div class="ms-2 fw-medium text-sm text-muted small">
        <small>
        Password Strength
        </small>
    </div>
</div>
