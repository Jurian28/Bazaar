@extends('components.layout')
@section('title', 'Make bid')

@section('content')
    <div class="container mt-5">
        @if($saleBids)
            @foreach($saleBids as $saleBid)
                <x-ad.sale :ad="$saleBid->advertisement"></x-ad.sale>
            @endforeach
        @endif
    </div>
@endsection
