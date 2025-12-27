<div class="">
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
            {{ $label }}
        </label>

    </div>
</div>