@props(['title', 'emptyText', 'ads'])


<div class="container my-5">
    <h1 class="mb-4">{{$title}}</h1>

    <div class="card p-4 mb-4 shadow-sm">
        <h5 class="mb-3">Filter Advertisements</h5>
        <form method="GET" class="row g-3">

            <!-- Search -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="Search title..."
                       value="{{ request('search') }}">
            </div>

            <!-- Type -->
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>Sale</option>
                    <option value="rental" {{ request('type') == 'rental' ? 'selected' : '' }}>Rental</option>
                </select>
            </div>

            <!-- Sale Filters -->
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control"
                       placeholder="Min Sale Price"
                       value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_bids" class="form-control"
                       placeholder="Max Bids"
                       value="{{ request('max_bids') }}">
            </div>

            <!-- Rental Filters -->
            <div class="col-md-2">
                <input type="number" name="price_per_day" class="form-control"
                       placeholder="Max Price/Day"
                       value="{{ request('price_per_day') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="wear_level" class="form-control"
                       placeholder="Wear Level"
                       value="{{ request('wear_level') }}">
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-2">
                <button class="btn btn-primary w-100">Apply Filters</button>
            </div>
        </form>
    </div>


    @if($ads->count() > 0)
        <div class="row">
            @foreach($ads as $ad)
                @if ($ad->type == 'sale')
                    <x-ad.sale :ad="$ad"></x-ad.sale>
                @elseif($ad->type == 'rental')
                    <x-ad.rental :ad="$ad"></x-ad.rental>
                @endif
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $ads->links() }}
        </div>
    @else
        <p>{{$emptyText}}</p>
    @endif
</div>
