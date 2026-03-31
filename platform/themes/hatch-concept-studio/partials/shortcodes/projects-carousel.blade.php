      @php
          // projects متوقع أن تأتي من الكنترولر أو من الشورتكود
          // إذا لم تكن موجودة، يمكن جلبها هنا (احتياطي)
          if (!isset($projects)) {
              $projects = \Botble\Projects\Models\Project::query()
                  ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
                  ->latest('id')
                  ->limit(8)
                  ->get();
          }
      @endphp

      @if ($projects->isNotEmpty())
          <div id="page3">
              <div class="swiper-container">
                  <div class="swiper-wrapper">
                      @foreach ($projects as $project)
                          <div class="swiper-slide">
                              <a href="{{ $project->url }}" class="slide-inner">
                                  <img src="{{ RvMedia::getImageUrl($project->cover ?: $project->image) }}"
                                      alt="{{ $project->title }}" loading="lazy" />
                              </a>
                          </div>
                      @endforeach
                  </div>
                  <!-- <div class="swiper-pagination"></div> -->
                  <div class="swiper-button-next">
                      Next Project
                      <i class="fa fa-arrow-right"></i>
                  </div>
                  <div class="swiper-button-prev">
                      <i class="fa fa-arrow-left"></i>
                      Previous Project
                  </div>
              </div>
          </div>
      @endif
