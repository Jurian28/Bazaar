@foreach(config('app.available_locales') as $locale => $name)
    <li>
        <a href="{{ route('change-locale', $locale) }}" class="{{ app()->getLocale() === $locale ? 'active' : '' }}">
            {{ $name }}
            {{--                                <img class="lang-flag" src="{{@asset('images/'.$locale.'.png')}}" alt="{{ $name }}">--}}
        </a>
    </li>
@endforeach
