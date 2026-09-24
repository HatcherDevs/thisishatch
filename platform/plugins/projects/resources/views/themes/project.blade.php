@php
use Botble\Shortcode\Facades\Shortcode;

$projectContent = $project->content ?? '';
$projectContent = htmlspecialchars_decode($projectContent, ENT_QUOTES);
$projectContent = preg_replace('/<shortcode(?:\s[^>]*)?>|<\ /shortcode>/i', '', $projectContent);
        $projectContent = str_replace(['\\"', '\\\\'], ['"', '\\'], $projectContent);
        $compiledProjectContent = $projectContent ? Shortcode::compile($projectContent) : '';
        ?>

        <section class="project-single">
            <div class="container">
                <h1>
                    {{ $project->title }}
                </h1>

                @if ($project->tagline)
                    <p>
                        {{ $project->tagline }}
                    </p>
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
                        {!! $compiledProjectContent !!}
                    </div>
                @endif
            </div>
        </section>
