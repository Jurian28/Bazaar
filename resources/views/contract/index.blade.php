@extends('components.layout')

@section('content')
    <div class="container">
        <h2>Companies</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Company Name</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($companies as $contractCompany)
                <tr>
                    <td>{{ $contractCompany->name }}</td>
                    <td>
                        <form action="{{ route('contract.download', $contractCompany->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Download Contract
                            </button>
                        </form>
                    </td>


                    <td>
                        <form action="{{ route('contract.upload.form', ['contractCompany' => $contractCompany->id]) }}"
                              method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Upload Contract
                            </button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
