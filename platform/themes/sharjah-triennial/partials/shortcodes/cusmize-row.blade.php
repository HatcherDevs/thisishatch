@php
    use Botble\Media\Facades\RvMedia;
    use Botble\Shortcode\Facades\Shortcode;
    $showMainTitle = $shortcode->show_main_title ?? '1';
    $mainTitle = $shortcode->main_title ?? '';
    $items = Shortcode::fields()->getTabsData(
        ['image', 'title', 'category', 'description', 'link', 'show_item'],
        $shortcode,
    );
@endphp

@if ($showMainTitle == '1' && !empty($mainTitle))
    <section class="event-section latest-initiatives-section container-fluid px-0 top_padding_categories">
        <div class="row justify-content-center">
            <div class="col-12">
                <hr class="latest-hr border-0 border-top border-black m-0 border-3" />
            </div>

            <div class="col-12">
                <h2 style="font-size: 26px" class="latest-title fw-medium mb-0 ps-0 py-2">
                    {{ $mainTitle }}
                </h2>
            </div>

            <div class="col-12">
                <hr class="latest-hr border-0 border-top border-black border-3 mb-3 mt-0" />
            </div>
        </div>
        <div>
            @if (!empty($items))
                <div class="row g-3 latest-grid">
                    @foreach ($items as $item)
                        @if (!isset($item['show_item']) || $item['show_item'] == '1')
                            <div class="col-6 col-xl-3 latest-card-wrap">
                                <div class="latest-card d-flex flex-column border-bottom border-black border-3">
                                    @if (!empty($item['link']))
                                        <a href="{{ $item['link'] }}" class="latest-card-link">Go to initiative</a>
                                    @endif
                                    <div class="latest-img-wrap">
                                        @if (!empty($item['image']))
                                            <img src="{{ RvMedia::getImageUrl($item['image'], 'medium', false, RvMedia::getDefaultImage()) }}"
                                                alt="{{ $item['title'] ?? '' }}" />
                                        @endif
                                    </div>
                                    <hr class="latest-hr border-0 border-top border-black border-3 m-0" />
                                    @if (!empty($item['title']))
                                        <div class="latest-title-wrap p-2 custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0"
                                            style="font-size: 20px !important">
                                            {{ $item['title'] }}
                                        </div>
                                    @endif
                                    @if (!empty($item['description']))
                                        <div class="latest-desc pt-1 custom-padding-bottom custom-font-size">
                                            {{ $item['description'] }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    @if (!empty($item['category']))
                                        <a href="#" class="btn tag my-2">{{ $item['category'] }}</a>
                                    <hr class="latest-hr"
                                        style="
                                    border: none;
                                    border-top: 3px solid #000;
                                    margin: 0 0 0 0;
                                " />
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
           
            @endif
        </div>
    </section>
@endif
