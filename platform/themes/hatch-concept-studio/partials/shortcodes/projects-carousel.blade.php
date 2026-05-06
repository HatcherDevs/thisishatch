      @php
          if (!isset($projects)) {
              $projects = \Botble\Projects\Models\Project::query()
                  ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
                  ->where('highlight', true)
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
                          <div class="swiper-slide" style="overflow: hidden;">
                              <a href="{{ $project->url }}" class="slide-inner">
                                  <img src="{{ RvMedia::getImageUrl($project->image ?: $project->cover) }}"
                                      alt="{{ $project->title }}" loading="lazy" />
                              </a>
                          </div>
                      @endforeach
                  </div>
                  <!-- <div class="swiper-pagination"></div> -->
                  {{-- <div class="swiper-button-next d-noe">
                      Next Project
                      <i class="fa fa-arrow-right"></i>
                  </div>
                  <div class="swiper-button-prev d-noe">
                      <i class="fa fa-arrow-left"></i>
                      Previous Project
                  </div> --}}
              </div>
          </div>
      @endif
