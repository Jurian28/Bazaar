<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="company-homepage" style="font-family: {{ $company->font_family ?? 'sans-serif' }};">
        {{-- Header --}}
        <header style="background-color: {{ $company->primary_color ?? '#333' }}; color: {{ $company->secondary_color ?? '#fff' }}; padding: 20px; text-align: center;">
            @if($company->logo_url)
                <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" style="max-height: 80px;">
            @endif
            <h1>{{ $company->name }}</h1>
        </header>

        {{-- Intro / description --}}
        <section style="padding: 20px; text-align: center;">
            <p>Welcome to {{ $company->name }}'s page! Check out our latest products and rentals below.</p>
        </section>

        {{-- Optional Footer --}}
        <footer style="padding: 20px; text-align: center; background-color: {{ $company->secondary_color ?? '#eee' }};">
            &copy; {{ date('Y') }} {{ $company->name }}
        </footer>
    </div>
</body>
</html>
