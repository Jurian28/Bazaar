@extends('company.layout')

@section('content')
    <div class="container mt-5">

        <h2>Homepage Builder</h2>

        <!-- COMPONENT LIST -->
        @foreach($components as $component)
            <div class="card p-3 mb-3">

                <strong>{{ ucfirst($component->type) }}</strong>

                <!-- Preview -->
                @if($component->type === 'text')
                    <p>{{ $component->data['text'] ?? '' }}</p>
                @endif

                @if($component->type === 'image')
                    <img src="{{ asset('storage/' . $component->data['image']) }}" style="max-height:150px; width: auto">
                @endif

                @if($component->type === 'ads')
                    <p>Ads block ({{ $component->data['limit'] ?? 6 }} items)</p>
                @endif

                <!-- ORDER AND DELETE BUTTONS -->
                <div class="mt-2">
                    <form method="POST" action="{{ route('company.components.changeOrder', ['direction' => 'up']) }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $component->id }}">
                        <button class="btn btn-sm btn-secondary">⬆️</button>
                    </form>

                    <form method="POST" action="{{ route('company.components.changeOrder', ['direction' => 'down']) }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $component->id }}">
                        <button class="btn btn-sm btn-secondary">⬇️</button>
                    </form>


                    <form method="POST" action="{{ route('company.components.delete') }}" style="display:inline;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $component->id }}">
                        <button class="btn btn-sm btn-secondary">❌</button>
                    </form>
                </div>

            </div>
        @endforeach


        <!-- ADD BUTTONS -->
        <div class="mt-5">
            <h4>Add component</h4>

            <!-- TEXT -->
            <form method="POST" action="{{ route('company.components.addText') }}" class="mb-3">
                @csrf
                <input type="text" name="title" placeholder="Title" class="form-control mb-2">
                <textarea name="text" placeholder="Text" class="form-control mb-2"></textarea>
                <button class="btn btn-primary">Add Text</button>
            </form>

            <!-- IMAGE -->
            <form method="POST" action="{{ route('company.components.addImage') }}" enctype="multipart/form-data" class="mb-3">
                @csrf
                <input type="file" name="image" class="form-control mb-2">
                <button class="btn btn-primary">Add Image</button>
            </form>

            <!-- ADS -->
            <form method="POST" action="{{ route('company.components.addAd') }}">
                @csrf
                <input type="text" name="title" placeholder="Title" class="form-control mb-2">
                <input type="number" name="limit" placeholder="Limit" class="form-control mb-2">
                <button class="btn btn-primary">Add Ads</button>
            </form>

        </div>

    </div>
@endsection
