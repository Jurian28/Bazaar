@extends('components.layout')
@section('title', __('Ad Page'))

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">{{ __('My sales') }}</h1>

        @if($ads->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">{{ __('Title') }}</th>
                        <th class="py-2 px-4 border-b">{{ __('Status') }}</th>
                        <th class="py-2 px-4 border-b"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        @if($ad->isSale())
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $ad->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $ad->sale_bids_exists ? __('sold') : __('open') }}</td>

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
            <p>{{ __('No sales found.') }}</p>
        @endif
    </div>
@endsection
