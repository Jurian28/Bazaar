@props(['color'])
@foreach(config('app.available_locales') as $locale => $name)
    <li class="nav-item">
        @if(app()->getLocale() !== $locale)
            <a href="{{ route('change-locale', $locale) }}" style="color: {{ $color }}"
               class="nav-link {{ app()->getLocale() === $locale ? 'active fw-bold' : '' }}">
                {{ $name }}
            </a>
        @endif
    </li>
@endforeach
