@php
    use App\Models\User;
    function isRole($role): bool {
        return $role == auth()->user()?->user_type;
    }
@endphp

<header>
    <nav class="navbar navbar-expand-lg" style="background-color: #6b7280;">
        <div class="container">
            <!-- Navbar links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{company_route('index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{company_route('ads')}}">ads page</a>
                </li>

                @if(isRole(User::TYPE_USER))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('favorites') }}">
                            Favorites
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('user.saleHistory') }}">
                            Purchased
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('user.rentalHistory') }}">
                            Rented
                        </a>
                    </li>
                @endif


                @if(isRole(User::TYPE_SELLER))
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{company_route('ad.create')}}">Create ad</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('seller.saleHistory') }}">
                            My Ads
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('seller.rentalOverview') }}">
                            Agenda
                        </a>
                    </li>
                @endif


                @if(isRole(User::TYPE_COMPANY))
                    <li class="nav-item">
                        <a class="nav-link text-white" href=" {{company_route('ad.create') }} ">
                            Create ad
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('company.showSettings') }}">
                            Settings
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{route('company.components') }}">
                            Components
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Authentication links -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @guest
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ company_route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ company_route('register') }}">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ company_route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link text-white p-0" style="display:inline;">
                                Log Out
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
</header>
