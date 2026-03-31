@props(['ad'])

<div class="col-md-6 col-lg-4 mb-4">
    <div class="card h-100 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $ad->title }}</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Price per day:</strong> {{ $ad->rental->price_per_day }}</li>
            <li class="list-group-item"><strong>Start date:</strong> {{ $ad->rental->start_date }}</li>
            <li class="list-group-item"><strong>End date:</strong> {{ $ad->rental->end_date }}</li>
            <li class="list-group-item"><strong>Company:</strong> {{ $ad->company->name }}</li>
            <li class="list-group-item"><strong>User:</strong> {{ $ad->user->name }}</li>
        </ul>
        <div class="card-body">
            <a href="{{ route('ads.show', ['adId' => $ad->id]) }}" class="btn btn-primary btn-sm">
                View Details
            </a>
            <x-likeButton :ad="$ad"></x-likeButton>
        </div>
    </div>
</div>
