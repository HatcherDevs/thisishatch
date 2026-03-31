@php
    $currentSlug = request()->segment(1);
@endphp
<div class="nav_about">
    <ul class="nav_list pl-0">
        @foreach ($menu_nodes as $key => $row)
            @php
                $rowSlug = ltrim(parse_url($row->url, PHP_URL_PATH), '/');
                $isActive = $rowSlug === $currentSlug;
            @endphp
            <div class="nav_list_item{{ $isActive || $row->active ? ' active' : '' }}">
                <li>
                    <a href="{{ url($row->url) }}" @if ($row->target !== '_self') target="{{ $row->target }}" @endif>
                        {!! $row->icon_html !!}
                        {{ $row->title }}
                    </a>
                </li>
            </div>
        @endforeach
    </ul>
</div>
