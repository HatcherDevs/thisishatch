@php
    use Botble\Theme\Facades\Theme;
 Theme::addBodyAttributes(['class' => 'home-page']);
    Theme::asset()
        // ->container('before_header')
        // ->container('after_header')
        ->usePath(false)
        ->add('home-locomotive-css', 'themes/hatch-concept-studio/css/locomotive-scroll.css')
        ->add('home-swiper-css', 'themes/hatch-concept-studio/css/swiper-bundle.min.css')
        ->add('home-slider-3d-css', 'themes/hatch-concept-studio/css/slider3D.css')
        ->add('home-style-css', 'themes/hatch-concept-studio/css/style.css')
        ->add('home-sections-css', 'themes/hatch-concept-studio/css/home-sections.css');
@endphp



<div class="container w-md-75">
    <h2 style="text-align: justify" class="pb-5">
        {!! BaseHelper::clean(
            theme_option(
                'projects_intro_text',
                'Our day begins and ends with doing what we love - grabbing design by the horns and beating it black and blue until it looks beautiful. You will find nothing but unadulterated, kicking, living design here.',
            ),
        ) !!}
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
                        <img id="arrow" width="15" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                            alt="Arrow" />
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
                    <img src="{{ RvMedia::getImageUrl($project->image ?: $project->cover) }}" class="card-img-top"
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

<script src="{{ Theme::asset()->url('js/popper.min.js') }}"></script>
<script src="{{ Theme::asset()->url('js/bootstrap.min.js') }}"></script>
<script src="{{ Theme::asset()->url('js/about.js') }}"></script>

  <script>
    function adjustWidthBasedOnNav() {
      // تحقق من أن حجم الشاشة هو حجم شاشة الهاتف
        if (window.matchMedia("(max-width: 767px)").matches) {
            // احصل على عرض #nav_about a
            var imgWidth = document.querySelector('#nav_about a').offsetWidth;
    
            // احسب النسبة المتبقية
            var remainingWidth = 100 - (imgWidth / window.innerWidth * 100);
            remainingWidth += 10.64;
    
            // قم بتعيين عرض #projects-tab
            document.querySelector('#projects-tab').style.width = remainingWidth + '%';
        } else {
            // إذا كانت الشاشة أكبر من 767px، يمكنك إعادة ضبط العرض أو تركه كما هو
            document.querySelector('#projects-tab').style.width = ''; // يعيد الضبط إلى القيمة الافتراضية
        }
    }
    
    // قم بتشغيل الوظيفة عند تحميل الصفحة
    adjustWidthBasedOnNav();
    
    // استمع لحدث تغير حجم الشاشة
    window.addEventListener('resize', adjustWidthBasedOnNav);
  

  </script>