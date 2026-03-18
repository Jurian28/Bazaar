
<header class="text-gray-600 body-font bg-gray-500">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <nav class="flex lg:w-2/5 flex-wrap items-center text-base md:ml-auto">
      <a class="mr-5 hover:text-gray-900 text-gray-100">First Link</a>
      <a class="mr-5 hover:text-gray-900 text-gray-100">Second Link</a>
      <a class="mr-5 hover:text-gray-900 text-gray-100">Third Link</a>
      <a class="hover:text-gray-900 text-gray-100">Fourth Link</a>
    </nav>
    <div class="lg:w-2/5 inline-flex lg:justify-end ml-5 lg:ml-0">
      <nav>
        @guest
            <a class="mr-5 hover:text-gray-900 text-gray-100" href="{{company_route('login')}}" :active="request()->is('login')">Login</a>
            <a class="mr-5 hover:text-gray-900 text-gray-100" href="{{company_route('register')}}" :active="request()->is('register')">Register</a>
        @endguest

        @auth
            <form method="POST" action="{{company_route('logout')}}">
            @csrf
            <button class="mr-5 hover:text-gray-900 text-gray=100">Log Out</button>
        </form>
        @endauth
    </nav>

    </div>
  </div>
</header>
