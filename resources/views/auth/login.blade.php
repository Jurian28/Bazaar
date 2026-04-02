<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<form class="max-w-md mx-auto mt-12 bg-white p-8 rounded-xl shadow-sm" method="POST" action="{{ company_route('login') }}">
    @csrf

    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">
        {{ __('Login to') }} {{ $company->name }}
    </h1>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm text-gray-600 mb-1">{{ __('Email') }}</label>
        <input
            type="email"
            name="email"
            id="email"
            :value="old('email')"
            placeholder="{{ __('name@email.com') }}"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
        />
        @error('email')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-6">
        <label for="password" class="block text-sm text-gray-600 mb-1">{{ __('Password') }}</label>
        <input
            type="password"
            name="password"
            id="password"
            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
        />
        @error('password')
        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700">
            {{ __('Cancel') }}
        </a>

        <button
            type="submit"
            class="bg-blue-600 text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-blue-700 transition"
        >
            {{ __('Login') }}
        </button>
    </div>
</form>
</body>
