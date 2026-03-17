@if (is_plugin_active('language'))
    @php
        $supportedLocales = Language::getSupportedLocales();
        $currentLocale = Language::getCurrentLocale();
    @endphp

    @if (count($supportedLocales) > 1)
        <div class="language-switcher dropdown d-inline-block">
            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="languageDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-globe me-1"></i>
                {{ strtoupper($currentLocale) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                @foreach ($supportedLocales as $localeCode => $properties)
                    @if ($localeCode != $currentLocale)
                        <li>
                            <a class="dropdown-item" href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}">
                                @if (isset($properties['lang_flag']))
                                    <img src="{{ asset($properties['lang_flag']) }}" alt="{{ $properties['lang_name'] }}" width="16"
                                        class="me-2">
                                @endif
                                {{ $properties['lang_name'] }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    @endif
@endif