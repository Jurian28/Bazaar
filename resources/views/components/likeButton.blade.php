@php use App\Models\User; @endphp
@props(['ad'])

@if (auth()?->user()?->user_type == User::TYPE_USER)
    @php
        $liked = $ad->favoritedBy()
            ->where('user_id', auth()->user()->id)
            ->exists();
    @endphp
    <form action="{{ route('ad.favorite', ['adId' => $ad->id]) }}" method="POST" class="d-inline">
        @csrf
        @if ($liked)
            <button type="submit" class="btn btn-primary btn-sm">Unlike</button>
        @else
            <button type="submit" class="btn btn-primary btn-sm">Like</button>
        @endif
    </form>
@endif
