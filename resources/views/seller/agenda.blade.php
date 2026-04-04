@extends('components.layout')
@section('title', __('Agenda'))

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-bold mb-4">{{ __('My Rental Agenda') }}</h1>

        @if($rentalBids->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">{{ __('Title') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Start Date') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('End Date') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Created At') }}</th>
                        <th class="py-2 px-4 border-b"></th>
                        <th class="py-2 px-4 border-b"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rentalBids as $bid)
                        @if($bid->advertisement->isRental())
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $bid->advertisement->title }}</td>
                                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($bid->start_date)->format('d M Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($bid->end_date)->format('d M Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $bid->created_at->format('d M Y') }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if ($bid->accepted === null)
                                        <a href="{{ route('rentalBid.accept', ['rentalBidId' => $bid->id]) }}"
                                           class="btn btn-success btn-sm">
                                            {{ __('Accept') }}
                                        </a>

                                        <a href="{{ route('rentalBid.decline', ['rentalBidId' => $bid->id]) }}"
                                           class="btn btn-danger btn-sm ml-2">
                                            {{ __('Decline') }}
                                        </a>

                                    @elseif ($bid->accepted)
                                        <span class="text-green-600 font-semibold">
                                            {{ __('Accepted') }}
                                        </span>

                                    @else
                                        <span class="text-red-600 font-semibold">
                                            {{ __('Declined') }}
                                        </span>
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
                {{ $rentalBids->links() }}
            </div>
        @else
            <p>{{ __('No rentals found.') }}</p>
        @endif
    </div>
@endsection
