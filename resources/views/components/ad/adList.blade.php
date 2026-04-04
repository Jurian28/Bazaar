@props(['title', 'emptyText', 'ads'])

<div class="container my-5">
    <h1 class="mb-4">{{ __($title) }}</h1>

    <div class="card p-4 mb-4 shadow-sm">
        <h5 class="mb-3">{{ __('Filter Advertisements') }}</h5>
        <form method="GET" class="row g-3">

            <!-- Search -->
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                       placeholder="{{ __('Search title...') }}"
                       value="{{ request('search') }}">
            </div>

            <!-- Type -->
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">{{ __('All Types') }}</option>
                    <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>{{ __('Sale') }}</option>
                    <option value="rental" {{ request('type') == 'rental' ? 'selected' : '' }}>{{ __('Rental') }}</option>
                    <option value="offer" {{ request('type') == 'offer' ? 'selected' : '' }}>{{ __('Offer') }}</option>
                </select>
            </div>

            <!-- Sale Filters -->
            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control"
                       placeholder="{{ __('Min Sale Price') }}"
                       value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_bids" class="form-control"
                       placeholder="{{ __('Max Bids') }}"
                       value="{{ request('max_bids') }}">
            </div>

            <!-- Rental Filters -->
            <div class="col-md-2">
                <input type="number" name="price_per_day" class="form-control"
                       placeholder="{{ __('Max Price/Day') }}"
                       value="{{ request('price_per_day') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="wear_level" class="form-control"
                       placeholder="{{ __('Wear Level') }}"
                       value="{{ request('wear_level') }}">
            </div>

            <!-- Submit Button -->
            <div class="col-12 mt-2">
                <button class="btn btn-primary w-100">{{ __('Apply Filters') }}</button>
            </div>
        </form>
    </div>

    @if($ads->count() > 0)
        <div class="row">
            @foreach($ads as $ad)
                @if ($ad->isSale())
                    <x-ad.sale :ad="$ad"></x-ad.sale>
                @elseif($ad->isRental())
                    <x-ad.rental :ad="$ad"></x-ad.rental>
                @elseif($ad->isOffer())
                    <x-ad.offer :ad="$ad"></x-ad.offer>
                @endif
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $ads->links() }}
        </div>
    @else
        <p>{{ __($emptyText) }}</p>
    @endif
</div>
