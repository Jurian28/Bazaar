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

<form method="POST" action="/create-ad" enctype="multipart/form-data" class="form-container">
    @csrf

    <h2>Create Your Ad</h2>

    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" name="photo" />
        @error('photo')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" value="{{ old('title') }}" />
        @error('title')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" name="description" value="{{ old('description') }}" />
        @error('description')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="price_per_day">Price per day:</label>
        <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" />
        @error('price_per_day')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" name="location" value="{{ old('location') }}" />
        @error('location')
        <p>{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="submit-btn">Create</button>
</form>
</body>
</html>
<style>
    .form-container {
        max-width: 600px;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 1rem;
        color: #333;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 0.6rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-group p {
        color: #e11d48;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .submit-btn {
        display: block;
        width: 100%;
        padding: 0.75rem;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #1d4ed8;
    }
</style>
