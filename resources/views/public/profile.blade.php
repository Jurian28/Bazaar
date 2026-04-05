@php use App\Models\User; @endphp
@extends('components.layout')
@section('title', 'Profile')

@section('content')
    <h1>{{$user->name}}</h1>
    @if($user->type == User::TYPE_COMPANY)
        <p>{{$user->company->name}}</p>
    @endif

    <div class="card shadow-sm p-4 mb-4">
        @if(auth()?->user()?->user_type == User::TYPE_USER)
            <h5 class="mb-3">{{ __('Leave a Review') }}</h5>

            <form method="POST" action="{{ route('profile.review', ['user' => $user]) }}">
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
@endsection
