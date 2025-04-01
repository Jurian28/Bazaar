<form method="POST" action="{{url('/login')}}">
    @csrf

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" :value="old('email')" required/>
    </div>

    <div>
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password" required/>
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>