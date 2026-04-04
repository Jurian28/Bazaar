@extends('components.layout')
@section('title', 'Offer history')

@section('content')
    <div class="container mt-5">
        @if($offerBids->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">{{ __('Title') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Price') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Status') }}</th>
                        <th class="py-2 px-4 border-b"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($offerBids as $bid)
                        @if($bid->advertisement->isOffer())
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $bid->advertisement->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $bid->price }}</td>

                                <td class="py-2 px-4 border-b">
                                    @if ($bid->accepted)
                                        {{ __('Accepted') }}
                                    @else
                                        {{ __('Waiting') }}
                                    @endif
                                </td>


                                <td class="py-2 px-4 border-b">
                                    <a href="{{ route('ads.show', ['adId' => $bid->advertisement->id]) }}" class="btn btn-primary btn-sm">
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
                {{ $offerBids->links() }}
            </div>
        @else
            <p>{{ __('No offers found.') }}</p>
        @endif
    </div>
@endsection
