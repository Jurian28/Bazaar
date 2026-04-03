@extends('company.layout')

@section('title', __('Other PageXXX'))

@section('content')
    <div class="upload-container">
        <h2>Upload CSV File</h2>
        <form action="{{ route('company.uploadAdCSV') }}" method="POST">
            <input type="file" id="fileInput" accept=".csv" required>
            <br>
            <button type="submit">Upload</button>
        </form>
    </div>
@endsection
