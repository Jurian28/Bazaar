@props(['ad'])

<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $ad->title }}</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>{{ __('Start price:') }}</strong> {{ $ad->offer?->start_price ?? __('N/A') }}</li>
            <li class="list-group-item"><strong>{{ __('End time:') }}</strong> {{ $ad->offer?->end_date ?? __('N/A') }}</li>
            <li class="list-group-item"><strong>{{ __('Company:') }}</strong> {{ $ad->company?->name ?? __('N/A') }}</li>
            <li class="list-group-item"><strong>{{ __('User:') }}</strong> {{ $ad->user?->name ?? __('N/A') }}</li>
        </ul>
        <div class="card-body">
            <a href="{{ route('ads.show', ['adId' => $ad->id]) }}" class="btn btn-primary btn-sm">
                {{ __('View Details') }}
            </a>
            <x-likeButton :ad="$ad"></x-likeButton>
        </div>
    </div>
</div>
