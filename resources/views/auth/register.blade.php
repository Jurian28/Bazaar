<form method="POST" action="{{url('/register')}}">
    @csrf

    <div>
        <label for="name">Naam</label>
        <input type="text" name="name" id="name" required/>
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" :value="old('email')" required/>
    </div>

    <div>
        <label for="password">Wachtwoord</label>
        <input type="password" name="password" id="password" required/>
    </div>

    <div>
        <label for="password_confirmation">Wachtwoord Herhaling</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required/>
    </div>

    <div>
        <label for="user_type">Type gebruiker</label>
        <select name="user_type" id="user_type">
            <option value="gebruiker">Gebruiker zonder adverteer mogelijkheden</option>
            <option value="particuliere_adverteerder">particuliere adverteerder</option>
            <option value="zakelijke_adverteerder">zakelijke adverteerder</option>
        </select>
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>