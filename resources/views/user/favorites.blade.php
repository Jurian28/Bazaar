@extends('components.layout')
@section('title', 'Ad Page')

@section('content')
    <x-ad.adList :ads="$ads" :title="'Favorites'" :emptyText="'No favorites found.'"></x-ad.adList>
@endsection
