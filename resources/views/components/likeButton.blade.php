<form action="{{ route('ad.favorite', ['adId' => $ad->id]) }}" method="POST" class="d-inline">
    @csrf
    <button type="submit" class="btn btn-primary btn-sm">Like</button>
</form>
