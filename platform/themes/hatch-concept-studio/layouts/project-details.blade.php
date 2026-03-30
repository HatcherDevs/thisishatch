{!! Theme::partial('header') !!}

<div id="main">
    <div class="container w-md-75">
        <div>
            <img
                src="{{ Theme::asset()->url('imgs/projects/project-details/details.png') }}"
                class="img-fluid"
                alt="Guided by the Stars – Ramadan illustrated pop-up book artwork by Hatch Concept Studio Dubai"
            />
            <div class="row pt-2">
                <div class="col-6">
                    <span style="color: #f8511e">2019</span>
                </div>
                <div class="col-6">
                    <a class="link-dark px-1 fw-bold text-decoration-none" href="#">Ramadan</a> |
                    <a class="link-dark px-1 fw-bold text-decoration-none" href="#">Dubai</a> |
                    <a class="link-dark px-1 fw-bold text-decoration-none" href="#">Digital Agency</a> |
                    <a class="link-dark px-1 fw-bold text-decoration-none" href="#">Graphic Design</a> |
                    <a class="link-dark px-1 fw-bold text-decoration-none" href="#">Illustration</a>
                </div>
            </div>

            <h2 class="pt-5 pb-3 fw-light" style="color: #f8511e">
                Guided By The Stars: A Ramadan Story
            </h2>
            <p class="fw-bold pb-5 w-75">
                "A boy wakes up in a celestial plane, surrounded by stars on the
                horizon. He wants to know why he's here and what is going on. He
                meets one of the stars, Respect, who tells him he might find answers
                once all the stars align…"
            </p>

            <div class="w-100 d-flex justify-content-end">
                <p class="w-75">
                    Ramadan is a time of reflection; we turn inwards &amp; seek to better
                    ourselves. The 30 days of fasting are guided by core values that
                    enhance our thinking &amp; the way we connect with those around us.
                    <br /><br />
                    Though this is a common sentiment amongst Muslims, how could we
                    bring it to life for all to relate to? We came up with a narrative
                    that follows a person's journey through Ramadan as they encounter
                    the stars. Each star represented a value - Patience, Remembrance,
                    Compassion, Respect and Reflection.
                    <br /><br />
                    The short-tale pop-up book was written &amp; illustrated in-house, &amp;
                    then given to our clients, families &amp; friends as a token of love
                    during the Holy Month. The choice of a pop-up book adds a dynamic
                    &amp; interactive dimension to the storytelling, making the journey
                    through Ramadan more vivid &amp; memorable.
                    <br /><br />
                    This book was a personal project to all those who worked on it, a
                    labor of love, crafted with sincerity &amp; authenticity.
                </p>
            </div>
        </div>
    </div>

    <div id="page3" class="pb-5 mb-5">
        <div class="swiper-container mySwiper pb-5 mb-5">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="#" class="slide-inner">
                        <img src="{{ Theme::asset()->url('imgs/projects/project-1.png') }}" alt="" />
                    </a>
                </div>
            </div>
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
</div>

{!! Theme::partial('footer') !!}
