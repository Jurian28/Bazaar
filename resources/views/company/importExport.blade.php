@extends('company.layout')

@section('title', __('Import Export'))

@section('content')
    <div class="upload-container">
        <h2>Upload CSV File</h2>
        <form action="{{ route('company.uploadAdCSV', ['companyId' => $company->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" id="fileInput" accept=".csv" required>
            <br>
            <button type="submit">Upload</button>
        </form>
    </div>
@endsection
