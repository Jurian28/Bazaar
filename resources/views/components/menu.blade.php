@props(['company'])
@php
    use App\Models\User;

    $primaryColor = $company->primary_color ?? '#6b7280';
    $secondaryColor = $company->secondary_color ?? '#ffffff';
    $fontFamily = $company->font_family ?? 'sans-serif';
@endphp

<header>
    <nav class="navbar navbar-expand-lg"
         style="background-color: {{ $primaryColor }}; font-family: {{ $fontFamily }};">
        <div class="container">
            <!-- Navbar links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ company_route('index') }}" style="color: {{ $secondaryColor }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ company_route('ads') }}" style="color: {{ $secondaryColor }}">{{ __('Ads') }}</a>
                </li>

                @if(auth()->user()?->isRole(User::TYPE_USER))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('favorites') }}" style="color: {{ $secondaryColor }}">{{ __('Favorites') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.saleHistory') }}" style="color: {{ $secondaryColor }}">{{ __('Purchased') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.offerHistory') }}" style="color: {{ $secondaryColor }}">{{ __('Bids') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.rentalHistory') }}" style="color: {{ $secondaryColor }}">{{ __('Rented') }}</a>
                    </li>
                @endif

                @if(auth()->user()?->isRole(User::TYPE_SELLER))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('ad.create') }}" style="color: {{ $secondaryColor }}">{{ __('Create Ad') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.saleHistory') }}" style="color: {{ $secondaryColor }}">{{ __('My sales') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.offerHistory') }}" style="color: {{ $secondaryColor }}">{{ __('My offers') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('seller.rentalOverview') }}" style="color: {{ $secondaryColor }}">{{ __('Agenda') }}</a>
                    </li>
                @endif

                @if(auth()->user()?->isRole(User::TYPE_COMPANY))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('ad.create') }}" style="color: {{ $secondaryColor }}">{{ __('Create Ad') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.showSettings') }}" style="color: {{ $secondaryColor }}">{{ __('Settings') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.components') }}" style="color: {{ $secondaryColor }}">{{ __('Components') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('company.importExport') }}" style="color: {{ $secondaryColor }}">{{ __('Import/Export') }}</a>
                    </li>


                    @if($company->id === 1) {{--  default company  --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contract.download.form') }}" style="color: {{ $secondaryColor }}">{{ __('Contracts') }}</a>
                    </li>
                    @endif
                @endif
            </ul>

            <!-- Authentication links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <x-language :color="$secondaryColor"/>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('login') }}" style="color: {{ $secondaryColor }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ company_route('register') }}" style="color: {{ $secondaryColor }}">{{ __('Register') }}</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item d-flex align-items-center">
                        <form method="POST" action="{{ company_route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit"
                                    class="nav-link btn btn-link"
                                    style="color: {{ $secondaryColor }};">
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
