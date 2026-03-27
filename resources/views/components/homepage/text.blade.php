@props(['component'])

<div class="container my-4">
    <div class="p-4 bg-light rounded">
        <h2>{{ $component->data['title'] ?? '' }}</h2>
        <p>{{ $component->data['text'] ?? '' }}</p>
    </div>
</div>
