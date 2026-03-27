@props(['component'])

<div class="container my-4">
    <img src="{{ asset('storage/' . $component->data['image']) }}"
         class="img-fluid rounded w-100"
         alt="Image">
</div>
