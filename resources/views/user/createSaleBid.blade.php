@extends('components.layout')
@section('title', 'Make bid')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Buy: {{ $ad->title }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $ad->title }}</h5>
                <p class="card-text">{{ $ad->description }}</p>
                <p><strong>Start price: €{{ number_format($ad->sale->start_price, 2) }}</strong></p>
                <p class="card-text">{{ $ad->end_time }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('ads.bid', $ad->id) }}">
            @csrf

            <div class="form-check mb-3">
                <label for="price"></label>
                <input
                    type="number"
                    name="price"
                    value="{{ $ad->sale->start_price }}"
                    min="{{ $ad->sale->start_price }}"
                    required
                >
            </div>

            <button type="submit" class="btn btn-success">Buy Now</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
