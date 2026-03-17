@php
    $isSubmenu = !empty($parentLevel ?? false);
    $currentLevel = $parentLevel ?? 0;
@endphp

@if ($isSubmenu)
    {{-- Nested submenu items --}}
    @foreach ($menu_nodes as $row)
        @if ($row->has_child)
            <li>
                <div class="navbar-mobile-link has-submenu ps-{{ $currentLevel * 3 }}">
                    <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                    <span class="mobile-link-text">{{ $row->title }}</span>
                </div>
                <ul class="mobile-submenu list-unstyled ps-{{ ($currentLevel + 1) * 3 }} mb-2" style="display: none">
                    @foreach ($row->child as $childRow)
                        @if ($childRow->has_child)
                            <li>
                                <div class="navbar-mobile-link has-submenu">
                                    <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                                    <span class="mobile-link-text">{{ $childRow->title }}</span>
                                </div>
                                <ul class="mobile-submenu list-unstyled ps-3 mb-2" style="display: none">
                                    @foreach ($childRow->child as $grandchildRow)
                                        @if ($grandchildRow->has_child)
                                            <li>
                                                <div class="navbar-mobile-link has-submenu">
                                                    <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                                                    <span class="mobile-link-text">{{ $grandchildRow->title }}</span>
                                                </div>
                                                <ul class="mobile-submenu list-unstyled ps-3 mb-2" style="display: none">
                                                    @foreach ($grandchildRow->child as $greatgrandchildRow)
                                                        <li><a href="{{ $greatgrandchildRow->url }}">{{ $greatgrandchildRow->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="{{ $grandchildRow->url }}">{{ $grandchildRow->title }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="{{ $childRow->url }}">{{ $childRow->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </li>
        @else
            <li><a href="{{ $row->url }}">{{ $row->title }}</a></li>
        @endif
    @endforeach
@else
    {{-- Top level menu items --}}
    @foreach ($menu_nodes as $row)
        @if ($row->has_child)
            <div class="navbar-mobile-link has-submenu">
                <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                <span class="mobile-link-text">{{ $row->title }}</span>
            </div>
            <ul class="mobile-submenu list-unstyled ps-3 mb-2" style="display: none">
                @foreach ($row->child as $childRow)
                    @if ($childRow->has_child)
                        <li>
                            <div class="navbar-mobile-link has-submenu">
                                <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                                <span class="mobile-link-text">{{ $childRow->title }}</span>
                            </div>
                            <ul class="mobile-submenu list-unstyled ps-3 mb-2" style="display: none">
                                @foreach ($childRow->child as $grandchildRow)
                                    @if ($grandchildRow->has_child)
                                        <li>
                                            <div class="navbar-mobile-link has-submenu">
                                                <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                                                <span class="mobile-link-text">{{ $grandchildRow->title }}</span>
                                            </div>
                                            <ul class="mobile-submenu list-unstyled ps-3 mb-2" style="display: none">
                                                @foreach ($grandchildRow->child as $greatgrandchildRow)
                                                    <li><a href="{{ $greatgrandchildRow->url }}">{{ $greatgrandchildRow->title }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li><a href="{{ $grandchildRow->url }}">{{ $grandchildRow->title }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ $childRow->url }}">{{ $childRow->title }}</a></li>
                    @endif
                @endforeach
            </ul>
        @else
            <a href="{{ $row->url }}" class="navbar-mobile-link">
                <span class="mobile-arrow"><i class="fa fa-arrow-right"></i></span>
                <span class="mobile-link-text">{{ $row->title }}</span>
            </a>
        @endif
    @endforeach
@endif