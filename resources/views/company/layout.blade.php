<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>@yield('title')</title>



</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary p-3">
    <a class="navbar-brand" href="#">{{ __('Dashboard') }}</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ company_route('index', ['companySlug' => auth()->user()->company->slug])}}">{{ __('Home') }}</a></li>
        </ul>
    </div>
</nav>

@yield('content')
</body>
</html>
