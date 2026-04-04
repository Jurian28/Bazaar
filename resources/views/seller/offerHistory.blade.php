@extends('components.layout')
@section('title', __('Ad Page'))

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">{{ __('My offers') }}</h1>

        @if($ads->count())
            {{ $ads }}
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">{{ __('Title') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('End Date') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Highest Offer') }}</th>
                        <th class="py-2 px-4 border-b"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        @if($ad->isOffer())
                            @php
                                $highestOffer = $ad->offerBids()->orderBy('price', 'desc')->value('price');
                            @endphp

                            <tr>
                                <td class="py-2 px-4 border-b">{{ $ad->title }}</td>
                                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($ad->offer->end_date)->format('d M Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $highestOffer ?? __('N/A')  }}</td>
                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('ads.show', ['adId' => $ad->id]) }}" class="btn btn-primary btn-sm">
                                        {{ __('View Details') }}
                                    </a>
                                </td>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $ads->links() }}
            </div>
        @else
            <p>{{ __('No bids found.') }}</p>
        @endif
    </div>
@endsection
