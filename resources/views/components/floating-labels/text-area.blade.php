<div wire:ignore>
    <div class="form-floating">

        <textarea
            class="form-control"
            placeholder="{{ $label }}"
            id="{{ $id }}"
            style="height: {{ is_numeric($height) ? $height . 'px' : $height }}"
            {{ $attributes->merge([
            'class' => 'form-control shadow-sm'
            ]) }}></textarea>

        <label for="{{ $id }}" class="small fw-medium">
            <small>{{ $label }}</small>
        </label>

    </div>
</div>

@error($id)
<div class="text-danger small mt-1">
    <small>{{ $message }}</small>
</div>
@enderror