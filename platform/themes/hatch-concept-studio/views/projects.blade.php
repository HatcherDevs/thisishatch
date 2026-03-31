<link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}">
<link rel="stylesheet" href="{{ Theme::asset()->url('css/projects.css') }}">

<div id="main" style="padding-top: 132px;">
    <div class="container w-md-75">
        <h2 style="text-align: justify" class="pb-5">
            Our day begins and ends with doing what we love - grabbing design by the horns and beating it black and blue
            until it looks beautiful.
            You will find nothing but unadulterated, kicking, living design here.
        </h2>

        @if ($categories->isNotEmpty())
            <ul class="nav nav-pills mb-4" id="projects-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link p-0 active" type="button" data-category="all">
                        <img id="arrow" width="15" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                            alt="Arrow" />
                        All
                    </button>
                </li>
                @foreach ($categories as $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link p-0" type="button" data-category="{{ $category->id }}">
                            <img id="arrow" width="15"
                                src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}" alt="Arrow" />
                            {{ $category->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="row pb-5 mb-5" id="projects-grid">
            @forelse ($projects as $project)
                <div class="col-md-6 mb-4 project-card" data-category="{{ $project->category_id ?: 'none' }}">
                    <a href="{{ $project->url }}" class="text-decoration-none project_item d-block">
                        <img src="{{ RvMedia::getImageUrl($project->cover ?: $project->image) }}" class="card-img-top"
                            alt="{{ $project->title }}" loading="lazy" />
                        <h5 class="card-title pt-2">{{ $project->title }}</h5>
                        <p>{{ $project->tags->pluck('name')->implode(' | ') ?: optional($project->category)->name }}
                        </p>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p>No projects found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    (function() {
        const tabList = document.getElementById('projects-tab');
        const tabButtons = Array.from(document.querySelectorAll('#projects-tab .nav-link'));
        const cards = Array.from(document.querySelectorAll('#projects-grid .project-card'));

        if (!tabList || !tabButtons.length || !cards.length) {
            return;
        }

        function applyFilter(button) {
            if (!button) {
                return;
            }

            const category = String(button.getAttribute('data-category') || '').trim();

            tabButtons.forEach((item) => {
                item.classList.remove('active');
                item.setAttribute('aria-pressed', 'false');
            });

            button.classList.add('active');
            button.setAttribute('aria-pressed', 'true');

            cards.forEach((card) => {
                const cardCategory = String(card.getAttribute('data-category') || '').trim();
                const shouldShow = category === 'all' || category === cardCategory;
                card.style.display = shouldShow ? '' : 'none';
            });
        }

        function onTabInteract(event) {
            const target = event.target instanceof Element ? event.target : null;
            const button = target ? target.closest('.nav-link[data-category]') : null;

            if (!button || !tabList.contains(button)) {
                return;
            }

            event.preventDefault();
            applyFilter(button);
        }

        tabList.addEventListener('click', onTabInteract, {
            passive: false
        });

        tabList.addEventListener('pointerup', onTabInteract, {
            passive: false
        });

        tabList.addEventListener('keydown', function(event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            onTabInteract(event);
        });
    })();
</script>
