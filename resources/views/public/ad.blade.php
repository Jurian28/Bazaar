@php use App\Models\User; @endphp
@extends('components.layout')
@section('title', $ad->title)

@section('content')
    <img class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title">{{ $ad->title }}</h2>
                <p class="card-text">{{ $ad->description }}</p>
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>{{ __('Type') }}:</strong> {{ ucfirst($ad->type) }}
                </li>

                <li class="list-group-item">
                    <strong>{{ __('Company') }}:</strong> {{ $ad->company?->name ?? __('N/A') }}
                </li>

                <li class="list-group-item">
                    <strong>{{ __('User') }}:</strong> {{ $ad->user?->name ?? __('N/A') }}
                </li>

                @if($ad->isSale())
                    <li class="list-group-item">
                        <strong>{{ __('Start price') }}:</strong>
                        €{{ number_format($ad->sale->start_price, 2) }}
                    </li>

                    <li class="list-group-item">
                        <strong>{{ __('End time') }}:</strong>
                        {{ $ad->sale->end_time }}
                    </li>
                @endif

                @if($ad->isRental())
                    <li class="list-group-item">
                        <strong>{{ __('Price per day') }}:</strong>
                        €{{ number_format($ad->rental->price_per_day, 2) }}
                    </li>

                    <li class="list-group-item">
                        <strong>{{ __('Max rentals') }}:</strong>
                        {{ $ad->rental->max_rentals }}
                    </li>
                @endif
            </ul>

            <div class="card-body">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                    {{ __('Back to List') }}
                </a>

                @if(auth()?->user()?->user_type === User::TYPE_USER)
                    @switch($ad->type)
                        @case('sale')
                            <a href="{{ route('ads.bid.form', $ad->id) }}" class="btn btn-primary btn-sm">
                                {{ __('Place Bid') }}
                            </a>
                            @break

                        @case('rental')
                            <a href="{{ route('ads.rent.form', $ad->id) }}" class="btn btn-primary btn-sm">
                                {{ __('Rent') }}
                            </a>
                            @break
                    @endswitch

                    <x-likeButton :ad="$ad"></x-likeButton>
                @endif
            </div>
        </div>



        <div class="card shadow-sm p-3 mb-3">

            @if(auth()?->user()?->user_type == User::TYPE_USER)
                <h5 class="mb-3">{{ __('Leave a Review') }}</h5>

                <form method="POST" action="{{ route('ads.review', ['adId' => $ad->id]) }}">
                    @csrf

                    <div class="mb-2">
                        <label for="rating" class="form-label">{{ __('Rating (1–5)') }}</label>
                        <input
                            type="number"
                            name="rating"
                            id="rating"
                            class="form-control"
                            min="1"
                            max="5"
                            required
                        >
                    </div>

                    <div class="mb-2">
                        <label for="comment" class="form-label">{{ __('Comment') }}</label>
                        <textarea
                            name="comment"
                            id="comment"
                            class="form-control"
                            rows="3"
                            placeholder="{{ __('Write your review...') }}"
                            required
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        {{ __('Submit Review') }}
                    </button>
                </form>

                <hr>
            @endif

            <h5>{{ __('Reviews') }}</h5>

            <form method="GET" class="mb-3">
                <label for="rating">{{ __('Filter by rating:') }}</label>
                <select name="rating" id="rating" class="form-select w-auto d-inline">
                    <option value="">{{ __('All') }}</option>
                    <option value="5">⭐ 5</option>
                    <option value="4">⭐ 4</option>
                    <option value="3">⭐ 3</option>
                    <option value="2">⭐ 2</option>
                    <option value="1">⭐ 1</option>
                </select>

                <button class="btn btn-sm btn-primary">{{ __('Filter') }}</button>
            </form>

            @forelse($reviews as $review)
                <div class="border rounded p-2 mb-2">
                    <strong>⭐ {{ $review->rating }}/5</strong>
                    <p class="mb-1">{{ $review->comment }}</p>
                    <small class="text-muted">
                        {{ __('Posted') }} {{ $review->created_at->diffForHumans() }}
                    </small>
                </div>
            @empty
                <p class="text-muted">{{ __('No reviews yet.') }}</p>
            @endforelse

            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
@endsection
