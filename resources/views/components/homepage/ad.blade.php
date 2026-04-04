@props(['component', 'company'])

@php
    $title = $component->data['title'];
    $limit = $component->data['limit'];
    $ads = $company->advertisements()->orderBy('created_at')->limit($limit)->get();
@endphp

<div class="container my-4">
    <div class="p-4 bg-light rounded">
        <h2>{{ __($title) }}</h2>
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

            {{-- Optional pagination --}}
            {{-- <div class="d-flex justify-content-center">
                {{ $ads->links() }}
            </div> --}}
        @endif
    </div>
</div>
