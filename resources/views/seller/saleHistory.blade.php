@extends('components.layout')
@section('title', 'Ad Page')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">My advertisements</h1>

        @if($ads->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">End Date</th>
                        <th class="py-2 px-4 border-b">Highest Offer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ads as $ad)
                        @if($ad->isSale())
                            @php
                                $highestOffer = $ad->saleBids()->orderBy('price', 'desc')->value('price');
                            @endphp

                            <tr>
                                <td class="py-2 px-4 border-b">{{ $ad->title }}</td>
                                <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($ad->sale->end_date)->format('d M Y H:i') }}</td>
                                <td class="py-2 px-4 border-b">{{ $highestOffer ?? 'N/A'  }}</td>
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
            <p>No sales found.</p>
        @endif
    </div>
@endsection
