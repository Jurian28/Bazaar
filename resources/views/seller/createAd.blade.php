@extends('components.layout')
@section('title', __('Create ad'))

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">{{ __('Create Advertisement') }}</h2>

        <form method="POST" action="{{ company_route('ad.create') }}">
            @csrf

            {{-- Basis --}}
            <div class="mb-3">
                <label class="form-label">{{ __('Title') }}</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Description') }}</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                @error('description') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            {{-- TYPE SELECT --}}
            <div class="mb-3">
                <label class="form-label">{{ __('Type') }}</label>
                <select name="type" id="typeSelect" class="form-control">
                    <option value="sale" {{ old('type') === 'sale' ? 'selected' : '' }}>{{ __('Sale') }}</option>
                    <option value="offer" {{ old('type') === 'offer' ? 'selected' : '' }}>{{ __('Offer') }}</option>
                    <option value="rental" {{ old('type') === 'rental' ? 'selected' : '' }}>{{ __('Rental') }}</option>
                </select>
            </div>

            {{-- OFFER --}}
            <div id="offerFields" style="display:none;">
                <div class="mb-3">
                    <label class="form-label">{{ __('Start price (€)') }}</label>
                    <input type="number" step="0.01" name="start_price" class="form-control" value="{{ old('start_price') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('End date') }}</label>
                    <input type="date" name="offer_end_date" class="form-control" value="{{ old('offer_end_date') }}">
                </div>
            </div>


            {{-- SALE --}}
            <div id="saleFields" style="display:none;">
                <div class="mb-3">
                    <label class="form-label">{{ __('Price (€)') }}</label>
                    <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}">
                </div>
            </div>


            {{-- RENTAL --}}
            <div id="rentalFields" style="display:none;">
                <div class="mb-3">
                    <label class="form-label">{{ __('Price per day (€)') }}</label>
                    <input type="number" step="0.01" name="price_per_day" class="form-control" value="{{ old('price_per_day') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Start date') }}</label>
                    <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('End date') }}</label>
                    <input type="date" name="rental_end_date" class="form-control" value="{{ old('rental_end_date') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary mb-5">
                {{ __('Create Ad') }}
            </button>

        </form>
    </div>

    <script>
        const typeSelect = document.getElementById('typeSelect');
        const offerFields = document.getElementById('offerFields');
        const saleFields = document.getElementById('saleFields');
        const rentalFields = document.getElementById('rentalFields');

        function toggleFields() {
            const type = typeSelect.value;

            saleFields.style.display = (type === 'sale') ? 'block' : 'none';
            offerFields.style.display = (type === 'offer') ? 'block' : 'none';
            rentalFields.style.display = (type === 'rental') ? 'block' : 'none';
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();
    </script>
@endsection
