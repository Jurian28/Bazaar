@extends('components.layout')
@section('title', 'Home page')

@section('content')
    <div class="grid grid-cols-3 gap-3">
        @foreach($components as $component)
            @switch($component->type)
                @case('image')
                    <x-homepage.image :component="$component" />
                    @break

                @case('text')
                    <x-homepage.text :component="$component" />
                    @break

                @case('ads')
                    <x-homepage.ad :component="$component" :company="$company" />
                    @break

            @endswitch
        @endforeach
    </div>
@endsection
