@extends('components.layout')
@section('title', $rental->title)

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title">{{ $rental->title }}</h2>
                <p class="card-text">{{ $rental->description }}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Price:</strong> ${{ $rental->price }}</li>
                <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($rental->type) }}</li>
                <li class="list-group-item"><strong>Company:</strong> {{ $rental->company?->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>User:</strong> {{ $rental->user?->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>Max Bids:</strong> {{ $rental->max_bids }}</li>
                <li class="list-group-item"><strong>Max Rentals:</strong> {{ $rental->max_rentals }}</li>
            </ul>
            <div class="card-body">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
        </div>
    </div>
@endsection
