@extends('components.layout')
@section('title', 'Ad Page')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Advertisements</h1>

        @if($ads->count() > 0)
            <div class="row">
                @foreach($ads as $ad)
                    @if ($ad->type == 'sale')
                        <x-ad.sale :ad="$ad"></x-ad.sale>
                    @elseif($ad->type == 'rental')
                        <x-ad.rental :ad="$ad"></x-ad.rental>
                    @endif
                @endforeach
            </div>

            {{--            <!-- Optional pagination -->--}}
            {{--            <div class="d-flex justify-content-center">--}}
            {{--                {{ $ads->links() }}--}}
            {{--            </div>--}}
        @else
            <p>No advertisements found.</p>
        @endif
    </div>
@endsection
