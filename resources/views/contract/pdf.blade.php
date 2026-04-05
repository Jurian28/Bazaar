<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>PDF</title>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="border-bottom mb-4 pb-3">
                        <h2 class="fw-bold mb-1">
                            Contract: {{ $title }}
                        </h2>
                        <small class="text-muted">
                            Created at: {{ now()->format('d M Y') }}
                        </small>
                    </div>

                    <div class="mb-4">

                        <div class="bg-light p-3 rounded mb-3">
                            <small class="text-muted">Company</small>
                            <div class="fw-medium">
                                {{ $company->name }}
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="border-top pt-3">
                        <small class="text-muted">Status</small>

                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
