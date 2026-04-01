@php
    $columns = $tabs ?? [];
    $count = count($columns);
    $count = $count > 0 ? $count : 1;
    $colSize = (int) floor(12 / $count);
    $colSize = $colSize >= 1 ? $colSize : 12;
@endphp

@once
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}">
@endonce

@if (!empty($columns))
    <div class="container">
        <div class="row">
            @foreach ($columns as $column)
                @php
                    $labels = preg_split(
                        '/\r\n|\r|\n|,/',
                        (string) ($column['loop_name'] ?? ''),
                        -1,
                        PREG_SPLIT_NO_EMPTY,
                    );
                    $labels = array_map('trim', $labels);
                    $labels = array_values(array_filter($labels, fn($item) => $item !== ''));

                    $links = preg_split('/\r\n|\r|\n|,/', (string) ($column['link'] ?? ''), -1, PREG_SPLIT_NO_EMPTY);
                    $links = array_map('trim', $links);
                    $links = array_values(array_filter($links, fn($item) => $item !== ''));
                @endphp
                <div class="col-md-{{ $colSize }}">
                    @if (!empty($column['col_title']))
                        <h4 class="font-weight-bold mb-3 nav-link">{{ $column['col_title'] }}</h4>
                    @endif
                    <ul class="list-unstyled">
                        @foreach ($labels as $index => $label)
                            @php
                                $href = $links[$index] ?? '#';
                            @endphp
                            <li><a href="{{ $href }}" class="custom-link">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endif
