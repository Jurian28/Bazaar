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
<form method="post" action="/create-ad" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
        <div style="color:red;">
            <strong>Whoops! Something went wrong:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <label for="name">Name:</label>
    <input type="text" name="name"> <br>

    <label for="description">Description:</label>
    <input type="text" name="description"> <br>

    <label for="price_per_day">Price per day:</label>
    <input type="number" name="price_per_day"> <br>

    <label for="location">Location:</label>
    <input type="text" name="location"> <br>

    <label for="photo">Photo:</label>
    <input type="file" name="photo"> <br>

    <button type="submit">Create</button>
</form>
</body>
</html>
