@extends('components.layout')
@section('title', __('Return rental'))

@section('content')
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">{{ __('Return Rental') }}</h2>

        <form action="{{ route('rental.return', ['rentalBidId' => $rentalBid->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">
                    {{ __('Upload return image') }}
                </label>

                <input type="file" name="return_image" accept="image/*"
                       class="w-full border p-2 rounded">

                @error('return_image')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Submit Return') }}
                </button>
            </div>
        </form>
    </div>

@endsection
