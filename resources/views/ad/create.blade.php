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
<form method="POST" action="/create-ad" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg space-y-4">
    @csrf

    <h2 class="text-2xl font-semibold text-center">Create Your Ad</h2>

    <!-- Photo Field -->
    <div>
        <label for="photo" class="block text-lg font-medium text-gray-700">Photo:</label>
        <input type="file" name="photo" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        @error('photo')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Title Field -->
    <div>
        <label for="title" class="block text-lg font-medium text-gray-700">Title:</label>
        <input type="text" name="title" value="{{ old('title') }}" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        @error('title')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description Field -->
    <div>
        <label for="description" class="block text-lg font-medium text-gray-700">Description:</label>
        <input type="text" name="description" value="{{ old('description') }}" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Price per Day Field -->
    <div>
        <label for="price_per_day" class="block text-lg font-medium text-gray-700">Price per day:</label>
        <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        @error('price_per_day')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Location Field -->
    <div>
        <label for="location" class="block text-lg font-medium text-gray-700">Location:</label>
        <input type="text" name="location" value="{{ old('location') }}" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
        @error('location')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Create
        </button>
    </div>
</form>
</body>
</html>
