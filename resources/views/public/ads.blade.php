@extends('components.layout')
@section('title', 'Ad Page')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Advertisements</h1>

        @if($ads->count() > 0)
            <div class="row">
                @foreach($ads as $ad)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $ad->title }}</h5>
                                <p class="card-text">{{ Str::limit($ad->description, 100) }}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Price:</strong> ${{ $ad->price }}</li>
                                <li class="list-group-item"><strong>Type:</strong> {{ ucfirst($ad->type) }}</li>
                                <li class="list-group-item"><strong>Company:</strong> {{ $company->name ?? 'N/A' }}</li>
                                <li class="list-group-item"><strong>User:</strong> {{ $ad->user->name ?? 'N/A' }}</li>
                            </ul>
                            <div class="card-body">
                                <a href="{{ route('ads.show', ['adId' => $ad->id]) }}" class="btn btn-primary btn-sm">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{--            <!-- Optional pagination -->--}}
            {{--            <div class="d-flex justify-content-center">--}}
            {{--                {{ $ads->links() }}--}}
            {{--            </div>--}}
        @else
            <p>No advertisements found.</p>
        @endif
    </div>
@endsection
