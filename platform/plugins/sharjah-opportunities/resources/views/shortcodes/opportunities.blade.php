<!-- About SAT Cards Section (dynamic) -->
 <style>
    .ck-content hr {
    border: none;
    border-top: var(--main-border);
    margin: 0;
    transition: var(--transition);
    border-width: 3px;
    border-color: #000;
    opacity: 1;
}
 </style>
<section class="mb-5 mt-5 pt-5">

    <hr class="divider" />
    <h3 class="my-2" style="font-size: 22px">Opportunities</h3>
    <hr class="divider" />
    <div class="row g-4 mt-1">
        @forelse($opportunities as $opportunity)
            @php
                $imageUrl = null;
                if (!empty($opportunity->image)) {
                if (class_exists('RvMedia')) {
                try {
                $imageUrl = RvMedia::getImageUrl($opportunity->image);
                } catch (\Throwable $e) {
                $imageUrl = $opportunity->image;
                }
                } else {
                $imageUrl = $opportunity->image;
                }
                }

                $title = $opportunity->name ?? '';
                $excerpt = \Illuminate\Support\Str::limit(strip_tags($opportunity->description ?? $opportunity->content
                ?? ''), 150);
            @endphp

            <div class="col-6 col-xl-3 latest-card-wrap">
                <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                    <a href="{{ route('opportunity.single', $opportunity->slug) }}"
                        class="latest-card-link">Go to initiative</a>
                    <div class="latest-img-wrap">
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $title }}" />
                        @endif
                    </div>
                    <hr class="latest-hr border-0 border-top border-black border-3 m-0" />
                    <div
                        class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0">
                        {{ $title }}
                    </div>
                    <div class="latest-desc pt-0 custom-padding-bottom pt-2">
                        {!! $excerpt !!}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p>No opportunities found.</p>
            </div>
        @endforelse
    </div>
</section>
