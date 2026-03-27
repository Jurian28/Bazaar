@props(['component', 'company'])

@php
    $title = $component->data['title'];
    $limit = $component->data['limit'];
    $ads = $company->advertisements()->orderBy('created_at')->limit($limit)->get();
@endphp

<div class="container my-4">
    <div class="p-4 bg-light rounded">
        <h2>{{ $title }}</h2>
        @foreach($ads as $ad)
            {{ $ad }}
        @endforeach
    </div>
</div>
