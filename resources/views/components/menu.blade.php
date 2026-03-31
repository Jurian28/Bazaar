@props(['company'])
@php
    use App\Models\User;

    function isRole($role): bool {
        return $role == auth()->user()?->user_type;
    }

    $primaryColor = $company->primary_color ?? '#6b7280';
    $secondaryColor = $company->secondary_color ?? '#ffffff';
    $fontFamily = $company->font_family ?? 'sans-serif';
@endphp

<header>
    <nav class="navbar navbar-expand-lg"
         style="background-color: {{ $primaryColor }}; font-family: {{ $fontFamily }};">
        <div class="container">
            <!-- Logo -->
            @if($company->logo_url)
                <a class="navbar-brand" href="{{ company_route('index') }}">
                    <img src="{{ $company->logo_url }}" alt="{{ $company->name }}" height="40">
                </a>
            @endif

            <!-- Navbar links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ company_route('index') }}" style="color: {{ $secondaryColor }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ company_route('ads') }}" style="color: {{ $secondaryColor }}">Ads Page</a>
                </li>

                @if(isRole(User::TYPE_USER))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites') }}" style="color: {{ $secondaryColor }}">Favorites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.saleHistory') }}" style="color: {{ $secondaryColor }}">Purchased</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.rentalHistory') }}" style="color: {{ $secondaryColor }}">Rented</a>
                    </li>
                @endif

                @if(isRole(User::TYPE_SELLER))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('ad.create') }}" style="color: {{ $secondaryColor }}">Create Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.saleHistory') }}" style="color: {{ $secondaryColor }}">My Ads</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.rentalOverview') }}" style="color: {{ $secondaryColor }}">Agenda</a>
                    </li>
                @endif

                @if(isRole(User::TYPE_COMPANY))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('ad.create') }}" style="color: {{ $secondaryColor }}">Create Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.showSettings') }}" style="color: {{ $secondaryColor }}">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.components') }}" style="color: {{ $secondaryColor }}">Components</a>
                    </li>
                @endif
            </ul>

            <!-- Authentication links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('login') }}" style="color: {{ $secondaryColor }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('register') }}" style="color: {{ $secondaryColor }}">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ company_route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link p-0"
                                    style="color: {{ $secondaryColor }}; display:inline;">
                                Log Out
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
