@php
    // Check if we're in a submenu (not top level)
    $isSubmenu = !empty($parentLevel ?? false);
@endphp

@foreach ($menu_nodes as $key => $row)
    @if ($row->has_child)
        @if ($isSubmenu)
            {{-- Nested submenu with children (dropdown-submenu) --}}
            <div class="dropdown-submenu {{ $row->css_class }}">
                <a href="{{ $row->url }}" title="{{ $row->title }}" target="{{ $row->target }}">
                    {!! BaseHelper::clean($row->icon_html) !!}
                    {{ $row->title }}
                </a>

                <div class="dropdown-menu">
                    {{-- Render children directly inside this dropdown-menu --}}
                    @foreach ($row->child as $childRow)
                        @if ($childRow->has_child)
                            {{-- Child with children (nested dropdown-submenu) --}}
                            <div class="dropdown-submenu {{ $childRow->css_class }}">
                                <a href="{{ $childRow->url }}" title="{{ $childRow->title }}" target="{{ $childRow->target }}">
                                    {!! BaseHelper::clean($childRow->icon_html) !!}
                                    {{ $childRow->title }}
                                </a>

                                <div class="dropdown-menu">
                                    {{-- Recursively render grandchildren --}}
                                    {!! Menu::generateMenu([
                                            'menu' => $menu,
                                            'menu_nodes' => $childRow->child,
                                            'view' => 'menu',
                                            'parentLevel' => true,
                                        ]) !!}
                                </div>
                            </div>
                        @else
                            {{-- Child link without children --}}
                            <a href="{{ $childRow->url }}" class="{{ $childRow->css_class }}" title="{{ $childRow->title }}"
                                target="{{ $childRow->target }}">
                                {!! BaseHelper::clean($childRow->icon_html) !!}
                                {{ $childRow->title }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            {{-- Top level with children (navbar-dropdown) --}}
            <div class="navbar-dropdown {{ $row->css_class }}">
                <a href="{{ $row->url }}" aria-label="{{ $row->title }}" class="navbar-link {{ $row->active ? 'active' : '' }}"
                    title="{{ $row->title }}" target="{{ $row->target }}">
                    {!! BaseHelper::clean($row->icon_html) !!}
                    {{ $row->title }}
                </a>

                <div class="dropdown-menu">
                    {{-- Render children directly inside this dropdown-menu --}}
                    @foreach ($row->child as $childRow)
                        @if ($childRow->has_child)
                            {{-- Child with children (dropdown-submenu) --}}
                            <div class="dropdown-submenu {{ $childRow->css_class }}">
                                <a href="{{ $childRow->url }}" title="{{ $childRow->title }}" target="{{ $childRow->target }}">
                                    {!! BaseHelper::clean($childRow->icon_html) !!}
                                    {{ $childRow->title }}
                                </a>

                                <div class="dropdown-menu">
                                    {{-- Recursively render grandchildren --}}
                                    {!! Menu::generateMenu([
                                            'menu' => $menu,
                                            'menu_nodes' => $childRow->child,
                                            'view' => 'menu',
                                            'parentLevel' => true,
                                        ]) !!}
                                </div>
                            </div>
                        @else
                            {{-- Child link without children --}}
                            <a href="{{ $childRow->url }}" class="{{ $childRow->css_class }}" title="{{ $childRow->title }}"
                                target="{{ $childRow->target }}">
                                {!! BaseHelper::clean($childRow->icon_html) !!}
                                {{ $childRow->title }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @else
        {{-- Link without children --}}
        @if ($isSubmenu)
        
              
              <a href="{{ $row->url }}" class="{{ $row->css_class }}" title="{{ $row->title }}" target="{{ $row->target }}">
                  {!! BaseHelper::clean($row->icon_html) !!}
                  {{ $row->title }}
              </a>

      

        @else
                  <div class="navbar-dropdown"> 

                      <a href="{{ $row->url }}" class="navbar-link {{ $row->css_class }} {{ $row->active ? 'active' : '' }}"
                          title="{{ $row->title }}" target="{{ $row->target }}">
                          {!! BaseHelper::clean($row->icon_html) !!}
                          {{ $row->title }}
                      </a>

                  </div>
        @endif
    @endif
@endforeach