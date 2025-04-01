<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>dit is de tijdelijke welkom pagina</div>
    @guest 
        <a href="{{url('/login')}}" :active="request()->is('login')">Login</a>
        <a href="{{url('/register')}}" :active="request()->is('register')">Register</a>
    @endguest

    @auth 
        <form method="POST" action="{{url('/logout')}}">
            @csrf
            <button>Log Out</button>
        </form>
    @endauth
</body>
</html>
