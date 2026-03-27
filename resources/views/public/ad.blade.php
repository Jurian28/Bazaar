@extends('components.layout')
@section('title', $ad->title)

@section('content')
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title">{{ $ad->title }}</h2>
                <p class="card-text">{{ $ad->description }}</p>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Type:</strong> {{ ucfirst($ad->type) }}
                </li>

                <li class="list-group-item">
                    <strong>Company:</strong> {{ $ad->company?->name ?? 'N/A' }}
                </li>

                <li class="list-group-item">
                    <strong>User:</strong> {{ $ad->user?->name ?? 'N/A' }}
                </li>

                @if($ad->isSale())
                    <li class="list-group-item">
                        <strong>Start price:</strong>
                        €{{ number_format($ad->sale->start_price, 2) }}
                    </li>

                    <li class="list-group-item">
                        <strong>End time:</strong>
                        {{ $ad->sale->end_time }}
                    </li>
                @endif

                @if($ad->isRental())
                    <li class="list-group-item">
                        <strong>Price per day:</strong>
                        €{{ number_format($ad->rental->price_per_day, 2) }}
                    </li>

                    <li class="list-group-item">
                        <strong>Deposit:</strong>
                        €{{ number_format($ad->rental->deposit, 2) }}
                    </li>

                    <li class="list-group-item">
                        <strong>Max rentals:</strong>
                        {{ $ad->rental->max_rentals }}
                    </li>
                @endif
            </ul>

            <div class="card-body">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    Back to List
                </a>

                @switch($ad->type)
                    @case('sale')
                        <a href="{{ route('ads.bid.form', $ad->id) }}" class="btn btn-primary btn-sm">
                            Place Bid
                        </a>
                        @break

                    @case('rental')
                        <a href="{{ route('ads.rent.form', $ad->id) }}" class="btn btn-primary btn-sm">
                            Rent
                        </a>
                        @break
                @endswitch
            </div>
        </div>
    </div>
@endsection
