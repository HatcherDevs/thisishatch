{!! Theme::partial('header') !!}

<ul class="nav nav-pills mb-3" id="projects-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link p-0 active" id="Branding-tab" data-bs-toggle="pill" data-bs-target="#Branding" type="button"
            role="tab" aria-controls="Branding" aria-selected="true">
            <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                alt="" />
            Branding
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link p-0" id="Web-Design-tab" data-bs-toggle="pill" data-bs-target="#Web-Design"
            type="button" role="tab" aria-controls="Web-Design" aria-selected="false">
            <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                alt="" />
            Web Design
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link p-0" id="Creative-Campaigns-tab" data-bs-toggle="pill"
            data-bs-target="#Creative-Campaigns" type="button" role="tab" aria-controls="Creative-Campaigns"
            aria-selected="false">
            <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                alt="" />
            Creative Campaigns
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link p-0" id="Motion-tab" data-bs-toggle="pill" data-bs-target="#Motion" type="button"
            role="tab" aria-controls="Motion" aria-selected="false">
            <img id="arrow" width="15px" src="{{ Theme::asset()->url('imgs/projects/Arrow.png') }}"
                alt="" />
            Motion
        </button>
    </li>
</ul>

<div id="main">
    <div class="container w-md-75">
        <h2 style="text-align: justify" class="pb-5">
            Our day begins and ends with doing what we love – grabbing design by
            the horns and beating it black and blue until it looks beautiful.
            You'll find nothing but unadulterated, kicking, living design here.
        </h2>

        <div class="tab-content pb-5 mb-5" id="pills-tabContent">
            <div class="tab-pane fade show active" id="Branding" role="tabpanel" aria-labelledby="Branding-tab">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/project-details/Guided-By-The-Stars.jpg') }}"
                                class="card-img-top"
                                alt="Guided by the Stars – Ramadan illustration and storytelling project by Hatch Concept Studio"
                                loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Watson's Regional Campaign" loading="lazy" />
                            <h5 class="card-title pt-2">Watson's Regional Campaign</h5>
                            <p>Concept | Campaign | Production</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="Web-Design" role="tabpanel" aria-labelledby="Web-Design-tab">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="Creative-Campaigns" role="tabpanel"
                aria-labelledby="Creative-Campaigns-tab">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="Motion" role="tabpanel" aria-labelledby="Motion-tab">
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('public.single', 'project-details') }}"
                            class="text-decoration-none project_item">
                            <img src="{{ Theme::asset()->url('imgs/projects/Project Image 1.png') }}"
                                class="card-img-top" alt="Project" loading="lazy" />
                            <h5 class="card-title pt-2">Guided by the Stars</h5>
                            <p>Illustration | Storytelling</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Theme::partial('footer') !!}
