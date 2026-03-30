<section class="project-single">
    <div class="container">
        <h1>{{ $project->title }}</h1>

        @if ($project->tagline)
            <p>{{ $project->tagline }}</p>
        @endif

        @if ($project->cover)
            <div class="project-cover">
                <img src="{{ RvMedia::getImageUrl($project->cover) }}" alt="{{ $project->title }}">
            </div>
        @endif

        @if ($project->description)
            <div class="project-description">
                {!! BaseHelper::clean($project->description) !!}
            </div>
        @endif

        @if ($project->content)
            <div class="project-content">
                {!! BaseHelper::clean(do_shortcode($project->content)) !!}
            </div>
        @endif
    </div>
</section>
