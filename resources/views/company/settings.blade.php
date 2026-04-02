@extends('company.layout')

@section('title', __('Settings Page'))

@section('content')
    <div class="container mx-auto p-6 max-w-lg">
        <h1 class="text-2xl font-bold mb-4">{{ __('Edit Company') }}</h1>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('company.updateSettings') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1 font-medium">{{ __('Name') }}</label>
                <input type="text" name="name" value="{{ old('name', $company->name) }}"
                       class="border rounded w-full p-2">
                @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
            </div>

            @if($company->id !== 1)
                <div class="mb-4">
                    <label class="block mb-1 font-medium">{{ __('Slug') }}</label>
                    <input type="text" name="slug" value="{{ old('slug', $company->slug) }}"
                           class="border rounded w-full p-2">
                    @error('slug') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            @endif

            <div class="mb-4">
                <label class="block mb-1 font-medium">{{ __('Primary Color') }}</label>
                <input type="color" name="primary_color" value="{{ old('primary_color', $company->primary_color ?? '#000000') }}">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">{{ __('Secondary Color') }}</label>
                <input type="color" name="secondary_color" value="{{ old('secondary_color', $company->secondary_color ?? '#ffffff') }}">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">{{ __('Logo URL') }}</label>
                <input type="url" name="logo_url" value="{{ old('logo_url', $company->logo_url) }}"
                       class="border rounded w-full p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">{{ __('Font Family') }}</label>
                <input type="text" name="font_family" value="{{ old('font_family', $company->font_family) }}"
                       class="border rounded w-full p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">{{ __('Update') }}</button>
        </form>
    </div>
@endsection
