@php use App\Models\User; @endphp
@extends('components.layout')
@section('title', $ad->title)

@section('content')
    <!-- Main Ad Card -->
    <div class="card shadow-sm mb-4">
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
                <strong>{{ __('User') }}:</strong>
                @if($ad->user)
                    <a href="{{ route('profile', ['user' =>$ad->user]) }}" class="text-decoration-none text-reset">
                        {{ $ad->user->name }}
                    </a>
                @else
                    {{ __('N/A') }}
                @endif
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

                <li class="list-group-item">
                    <strong>{{ __('Start time') }}:</strong>
                    {{ $ad->rental->start_date }}
                </li>
                <li class="list-group-item">
                    <strong>{{ __('End time') }}:</strong>
                    {{ $ad->rental->end_date }}
                </li>
                <li class="list-group-item">
                    <strong>{{ __('Wear level') }}:</strong>
                    {{$ad->rental->wear_level }}
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

            <img src="{{ $qrCode }}" alt="qr code" style="width: 100px; height: 100px;">
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
        <div class="row g-4">
            <div class="{{ $ad->isOffer() ? 'col-md-8' : 'col-12' }}">
                <div class="card shadow-sm p-4 mb-4">
                    @if(auth()?->user()?->user_type == User::TYPE_USER)
                        <h5 class="mb-3">{{ __('Leave a Review') }}</h5>

                        <form method="POST" action="{{ route('ads.review', ['adId' => $ad->id]) }}">
                            @csrf

                            <div class="mb-3">
                                <label for="rating" class="form-label">{{ __('Rating (1–5)') }}</label>
                                <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">{{ __('Comment') }}</label>
                                <textarea name="comment" id="comment" class="form-control" rows="3" required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm">
                                {{ __('Submit Review') }}
                            </button>
                        </form>

                        <hr class="my-4">
                    @endif

                    <h5 class="mb-3">{{ __('Reviews') }}</h5>

                    <form method="GET" class="mb-4">
                        <label class="me-2">{{ __('Filter by rating:') }}</label>
                        <select name="rating" class="form-select w-auto d-inline">
                            <option value="">{{ __('All') }}</option>
                            <option value="5">⭐ 5</option>
                            <option value="4">⭐ 4</option>
                            <option value="3">⭐ 3</option>
                            <option value="2">⭐ 2</option>
                            <option value="1">⭐ 1</option>
                        </select>

                        <button class="btn btn-sm btn-primary ms-2">{{ __('Filter') }}</button>
                    </form>

                    @forelse($reviews as $review)
                        <div class="border rounded p-3 mb-3">
                            <strong>⭐ {{ $review->rating }}/5</strong>
                            <p class="mb-1">{{ $review->sender->name }}</p>
                            <p class="mb-1">{{ $review->comment }}</p>
                            <small class="text-muted">
                                {{ __('Posted') }} {{ $review->created_at->diffForHumans() }}
                            </small>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('No reviews yet.') }}</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>

            <!-- Offer Bids -->
            @if($ad->isOffer())
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 mb-4">
                        <h5 class="mb-3">{{ __('Top Offer Bids') }}</h5>

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>{{__('User')}}</th>
                                <th>{{__('Price')}}</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ad->OfferBids->sortByDesc('price')->take(5) as $bid)
                                <tr>
                                    <td>{{ $bid->user->name }}</td>
                                    <td>€{{ $bid->price }}</td>

                                    @if($ad->user == auth()->user())
                                        <td class="py-2 px-4 border-b">

                                            @if($ad->offerAccepted())
                                                @if($bid->accepted)
                                                    <span class="text-green-600 font-bold">Accepted</span>
                                                @else
                                                    <span class="text-red-600">Rejected</span>
                                                @endif

                                            @else

                                                <a href="{{ route('offerBid.accept', ['offerBidId' => $bid->id]) }}"
                                                   class="btn btn-primary btn-sm">
                                                    {{ __('Accept') }}
                                                </a>
                                            @endif
                                        </td>
                                    @endif
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
