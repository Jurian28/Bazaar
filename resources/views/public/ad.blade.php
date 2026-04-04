@php use App\Models\User; @endphp
@extends('components.layout')
@section('title', $ad->title)

@section('content')
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
                    <strong>{{ __('Price') }}:</strong>
                    €{{ number_format($ad->sale->price, 2) }}
                </li>
            @endif

            @if($ad->isRental())
                <li class="list-group-item">
                    <strong>{{ __('Price per day') }}:</strong>
                    €{{ number_format($ad->rental->price_per_day, 2) }}
                </li>
            @endif


            @if($ad->isOffer())
                <li class="list-group-item">
                    <strong>{{ __('Start price') }}:</strong>
                    €{{ number_format($ad->offer->start_price, 2) }}
                </li>

                <li class="list-group-item">
                    <strong>{{ __('End time') }}:</strong>
                    {{ $ad->offer->end_date }}
                </li>
            @endif

        </ul>
        <div class="card-body">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
                {{ __('Back to List') }}
            </a>

            @if(auth()?->user()?->user_type === User::TYPE_USER)
                @switch($ad->type)
                    @case('offer')
                        <a href="{{ route('ads.bid.form', $ad->id) }}" class="btn btn-primary btn-sm">
                            {{ __('Place Bid') }}
                        </a>
                        @break

                    @case('rental')
                        <a href="{{ route('ads.rent.form', $ad->id) }}" class="btn btn-primary btn-sm">
                            {{ __('Rent') }}
                        </a>
                        @break

                    @case('sale')
                        <form action="{{ route('ads.buy', $ad->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Buy') }}
                            </button>
                        </form>
                        @break

                @endswitch

                <x-likeButton :ad="$ad"></x-likeButton>
            @endif
        </div>
    </div>




    @if(!$ad->isSale())
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm p-3 mb-3">
                    @if(auth()?->user()?->user_type == User::TYPE_USER)
                        <h5 class="mb-3">{{ __('Leave a Review') }}</h5>

                        <form method="POST" action="{{ route('ads.review', ['adId' => $ad->id]) }}">
                            @csrf

                            <div class="mb-2">
                                <label for="rating" class="form-label">{{ __('Rating (1–5)') }}</label>
                                <input type="number" name="rating" class="form-control" min="1" max="5" required>
                            </div>

                            <div class="mb-2">
                                <label for="comment" class="form-label">{{ __('Comment') }}</label>
                                <textarea name="comment" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Submit Review') }}
                            </button>
                        </form>

                        <hr>
                    @endif

                    <h5>{{ __('Reviews') }}</h5>

                    <form method="GET" class="mb-3">
                        <label>{{ __('Filter by rating:') }}</label>
                        <select name="rating" class="form-select w-auto d-inline">
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

            @if($ad->isOffer())
                <div class="col-md-4">
                    <div class="card shadow-sm p-3 mb-3">
                        <h5>{{ __('Top Offer Bids') }}</h5>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>{{__('User')}}</th>
                                <th>{{__('Price')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ad->OfferBids->sortByDesc('price')->take(5) as $bid)
                                <tr>
                                    <td>{{ $bid->user->name }}</td>
                                    <td>€{{ $bid->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection
