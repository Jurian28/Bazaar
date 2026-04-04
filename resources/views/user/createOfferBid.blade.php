@extends('components.layout')
@section('title', __('Make bid'))

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __('Buy') }}: {{ $ad->title }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $ad->title }}</h5>
                <p>
                    <strong>{{ __('Start price') }}: €{{ number_format($ad->offer->start_price, 2) }}</strong>
                </p>
                <p class="card-text">{{ $ad->offer->end_time }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('ads.bid', $ad->id) }}">
            @csrf

            <div class="form-check mb-3">
                <label for="price">{{ __('Your bid') }}</label>
                <input
                    type="number"
                    name="price"
                    value="{{ $ad->offer->start_price }}"
                    min="{{ $ad->offer->start_price }}"
                    required
                >
            </div>

            <button type="submit" class="btn btn-success">{{ __('Place bid') }}</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        </form>
    </div>
@endsection
