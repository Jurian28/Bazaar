@extends('components.layout')
@section('title', 'Ad Page')

@section('content')
    <x-ad.adList
        :ads="$ads"
        :title="__('Advertisements')"
        :emptyText="__('No advertisements found.')">
    </x-ad.adList>
@endsection
