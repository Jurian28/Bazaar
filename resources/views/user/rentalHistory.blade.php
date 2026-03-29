@extends('components.layout')
@section('title', 'Agenda')

@section('content')
    <div class="container mt-5">
        <h1 class="text-2xl font-bold mb-4">My Rentals</h1>

        @if($rentalBids->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="py-2 px-4 border-b">Title</th>
                        <th class="py-2 px-4 border-b">Start Date</th>
                        <th class="py-2 px-4 border-b">End Date</th>
                        <th class="py-2 px-4 border-b">Created At</th>
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
            <p>No rentals found.</p>
        @endif
    </div>
@endsection
