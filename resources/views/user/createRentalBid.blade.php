@extends('components.layout')
@section('title', 'Rent item')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Rent: {{ $ad->title }}</h2>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $ad->title }}</h5>
                <p class="card-text">{{ $ad->description }}</p>

                <p><strong>Price per day: €{{ number_format($ad->rental->price_per_day, 2) }}</strong></p>
                <p><strong>Deposit: €{{ number_format($ad->rental->deposit, 2) }}</strong></p>
            </div>
        </div>

        <form method="POST" action="{{ route('ads.rent', $ad->id) }}">
            @csrf

            <div class="mb-3">
                <label for="start_date">Start date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_date">End date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Rent now</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
