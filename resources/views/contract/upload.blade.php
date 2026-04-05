@extends('components.layout')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Upload & Sign Contract for {{ $company->name }}</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if(!$company->contract?->path)
            <form action="{{ route('contract.upload', $company) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="contract" class="form-label">Upload PDF Contract</label>
                    <input class="form-control" type="file" id="contract" name="contract" accept="application/pdf">
                </div>
                <button type="submit" class="btn btn-primary">Upload Contract</button>
            </form>

        @else

            @if (!$company->contract->signed_at)
                <form action="{{ route('contract.sign', $company->contract) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Sign Contract</button>
                </form>
            @else
                <p>Signed</p>
            @endif
        @endif
    </div>
@endsection
