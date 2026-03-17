{{-- Layout for Repository pages --}}
@extends('theme.sharjah-triennial::layouts.master')

@section('content')
    <main class="event-section whatsOn_page mt-0">
        <!-- About Section -->
        <section class="row mb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-8">
                        <hr class="divider" />
                        <h2 class="" style="font-size: 26px; margin: 6px 0 ;">Repository</h2>
                        <hr class="divider" />
                    </div>
                    <div class="col-md-4">
                        <div class="select-date-wrap">

                            <div class="col">
                                <select class="form-select" id="mediaFilter" aria-label="Types">
                                    <option selected value="all">All Media</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About SAT Cards Section -->
        <section class="mb-4 mt-5">

            <div class="row g-3 mt-1">
                @forelse($repositories as $repository)
                    <!-- Card -->
                    <div class="col-6 col-xl-3 latest-card-wrap" data-category="{{ $repository->category_id }}">
                        <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                            <a href="{{ !empty($repository->slug) ? url('repositories/' . $repository->slug) : '#' }}"
                                class="latest-card-link">Go to initiative</a>
                            <div class="latest-img-wrap">
                                <img src="{{ RvMedia::getImageUrl($repository->image) }}" alt="{{ $repository->title }}" />
                            </div>

                            <div
                                class="d-flex justify-content-between latest-title-wrap p-2 fw-bold custom-font-size custom-margin-bottom ps-0 d-none">
                                <div>
                                    <span class="">{{ $repository->created_at->format('F d') }}</span>
                                </div>
                                <div>
                                    <span class="">{{ $repository->category->name ?? '-' }}</span>
                                </div>
                            </div>

                            <div
                                class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-top border-black border-3 custom-margin-bottom ps-0">
                                {{ $repository->title }}
                            </div>
                            <div class="latest-desc pt-0 custom-padding-bottom custom-font-size pt-2">
                                {!! Str::limit(strip_tags($repository->content), 100) !!}
                            </div>
                        </div>
                        <div>
                            <a href="" class="btn tag my-2">{{ $repository->category->name ?? 'Repository' }}</a>
                            <hr class="latest-hr"
                                style="
                  border: none;
                  border-top: 3px solid #000;
                  margin: 0 0 0 0;
                " />
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No repositories found.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterSelect = document.getElementById('mediaFilter');
            const cards = document.querySelectorAll('[data-category]');

            if (filterSelect && cards.length > 0) {
                filterSelect.addEventListener('change', function() {
                    const selectedCategory = this.value;

                    cards.forEach(card => {
                        if (selectedCategory === 'all' || card.getAttribute('data-category') ===
                            selectedCategory) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
@endsection
