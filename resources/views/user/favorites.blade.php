@extends('components.layout')
@section('title', __('Ad Page'))

@section('content')
    <x-ad.adList
        :ads="$ads"
        :title="__('Favorites')"
        :emptyText="__('No favorites found.')">
    </x-ad.adList>
@endsection
