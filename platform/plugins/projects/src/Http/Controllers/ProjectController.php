<?php

namespace Botble\Projects\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Projects\Forms\ProjectForm;
use Botble\Projects\Http\Requests\ProjectRequest;
use Botble\Projects\Models\Project;
use Botble\Projects\Models\ProjectTag;
use Botble\Projects\Tables\ProjectTable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProjectController extends BaseController
{
    public function index(ProjectTable $table)
    {
        $this->pageTitle(trans('plugins/projects::projects.name'));

        return $table->renderTable();
    }

    public function create(): string
    {
        $this->pageTitle(trans('plugins/projects::projects.create'));

        return ProjectForm::create()->renderForm();
    }

    public function store(ProjectRequest $request)
    {
        $this->mergeVideosJson($request);

        $form = ProjectForm::create();
        $form->setRequest($request)->save();

        /** @var Project $project */
        $project = $form->getModel();

        $this->syncTags($project, $request->input('tag_names'));

        return $this
            ->httpResponse()
            ->setNextUrl(route('projects.index'))
            ->withCreatedSuccessMessage();
    }

    public function edit(Project $project): string
    {
        $this->pageTitle(trans('core/base::forms.edit_item', ['name' => $project->title]));

        return ProjectForm::createFromModel($project)->renderForm();
    }

    public function update(Project $project, ProjectRequest $request)
    {
        $this->mergeVideosJson($request);

        ProjectForm::createFromModel($project)->setRequest($request)->save();

        $this->syncTags($project, $request->input('tag_names'));

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('projects.index'))
            ->withUpdatedSuccessMessage();
    }

    public function destroy(Project $project)
    {
        return DeleteResourceAction::make($project);
    }

    public function moveUp(Project $project)
    {
        return $this->move($project, 'up');
    }

    public function moveDown(Project $project)
    {
        return $this->move($project, 'down');
    }

    public function reorder(Request $request)
    {
        $requestedIds = collect((array) $request->input('ids', []))
            ->map(static fn ($id) => (int) $id)
            ->filter(static fn (int $id) => $id > 0)
            ->unique()
            ->values();

        if ($requestedIds->isEmpty()) {
            return $this->httpResponse()
                ->setError()
                ->setMessage('No projects selected for reordering.');
        }

        $existingOrderedIds = Project::query()
            ->orderBy('order')
            ->orderByDesc('id')
            ->pluck('id');

        $validRequestedIds = $requestedIds
            ->intersect($existingOrderedIds)
            ->values();

        $remainingIds = $existingOrderedIds
            ->reject(fn (int $id) => $validRequestedIds->contains($id))
            ->values();

        $finalOrder = $validRequestedIds
            ->merge($remainingIds)
            ->values();

        DB::transaction(function () use ($finalOrder): void {
            foreach ($finalOrder as $index => $projectId) {
                Project::query()
                    ->whereKey($projectId)
                    ->update([
                        'order' => ($index + 1) * 10,
                    ]);
            }
        });

        return $this->httpResponse()->withUpdatedSuccessMessage();
    }

    public function toggleHighlight(Project $project, Request $request)
    {
        $project->update([
            'highlight' => $request->boolean('highlight'),
        ]);

        return $this->httpResponse()->withUpdatedSuccessMessage();
    }

    protected function mergeVideosJson(ProjectRequest $request): void
    {
        $json = $request->input('videos_json', '[]');
        $videos = json_decode($json, true);
        $request->merge([
            'videos' => is_array($videos) ? $videos : [],
            'gallery_images' => array_values(array_filter((array) $request->input('gallery_images', []))),
            'highlight' => $request->boolean('highlight'),
        ]);
    }

    protected function syncTags(Project $project, string|array|null $tagInput): void
    {
        $names = $this->normalizeTagNames($tagInput)
            ->filter()
            ->unique()
            ->values();

        if ($names->isEmpty()) {
            $project->tags()->sync([]);

            return;
        }

        $tagIds = $names
            ->map(fn (string $name) => ProjectTag::query()->firstOrCreate(['name' => $name])->getKey())
            ->all();

        $project->tags()->sync($tagIds);
    }

    protected function normalizeTagNames(string|array|null $tagInput): Collection
    {
        if (is_array($tagInput)) {
            return Collection::make($tagInput)->map(fn ($tag) => $this->extractTagName($tag));
        }

        $tagInput = trim((string) $tagInput);

        if ($tagInput === '') {
            return collect();
        }

        $decoded = json_decode($tagInput, true);

        if (is_array($decoded)) {
            return Collection::make($decoded)->map(fn ($tag) => $this->extractTagName($tag));
        }

        return Collection::make(explode(',', $tagInput))
            ->map(fn ($tag) => $this->extractTagName($tag));
    }

    protected function extractTagName(mixed $tag): string
    {
        if (is_array($tag)) {
            return trim((string) ($tag['value'] ?? $tag['name'] ?? ''));
        }

        $tag = trim((string) $tag);

        if ($tag === '') {
            return '';
        }

        $decoded = json_decode($tag, true);

        if (is_array($decoded)) {
            if (array_is_list($decoded)) {
                $first = $decoded[0] ?? null;

                if (is_array($first)) {
                    return trim((string) ($first['value'] ?? $first['name'] ?? ''));
                }
            }

            return trim((string) ($decoded['value'] ?? $decoded['name'] ?? ''));
        }

        if (preg_match('/"value"\s*:\s*"([^"]+)"/', $tag, $matches) === 1) {
            return trim($matches[1]);
        }

        return trim($tag, " \t\n\r\0\x0B[]{}\"'");
    }

    protected function move(Project $project, string $direction)
    {
        $orderedProjectIds = Project::query()
            ->orderBy('order')
            ->orderByDesc('id')
            ->pluck('id')
            ->all();

        $currentIndex = array_search($project->getKey(), $orderedProjectIds, true);

        if ($currentIndex === false) {
            return $this->httpResponse()
                ->setPreviousUrl(route('projects.index'))
                ->setError()
                ->setMessage(trans('core/base::notices.not_found_message'));
        }

        $targetIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;

        if (! isset($orderedProjectIds[$targetIndex])) {
            return $this->httpResponse()
                ->setPreviousUrl(route('projects.index'))
                ->withUpdatedSuccessMessage();
        }

        [$orderedProjectIds[$currentIndex], $orderedProjectIds[$targetIndex]] = [$orderedProjectIds[$targetIndex], $orderedProjectIds[$currentIndex]];

        foreach ($orderedProjectIds as $index => $projectId) {
            Project::query()->whereKey($projectId)->update([
                'order' => ($index + 1) * 10,
            ]);
        }

        return $this->httpResponse()
            ->setPreviousUrl(route('projects.index'))
            ->withUpdatedSuccessMessage();
    }
}
