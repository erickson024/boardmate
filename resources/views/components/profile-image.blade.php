@php
$initials = strtoupper(substr($firstName, 0,1) . substr($lastName, 0,1));
@endphp

@if($image)
<img
    src="{{ asset('storage/' . $image)}}"
    alt="Profile Image"
    class="rounded-circle object-fit-cover"
    style="
    width: {{ $size }}px; 
    height: {{ $size }}px;
    ">
@else
<div
    class="rounded-circle d-flex justify-content-center align-items-center bg-dark text-white fw-bold"
    style="
    width: {{ $size }}px; 
    height: {{ $size }}px; 
    font-size: {{ $size / 2.5 }}px;
    ">
    {{ $initials }}
</div>
@endif