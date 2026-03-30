<?php

namespace Botble\Projects\Http\Controllers;

use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Projects\Forms\ProjectForm;
use Botble\Projects\Http\Requests\ProjectRequest;
use Botble\Projects\Models\Project;
use Botble\Projects\Models\ProjectTag;
use Botble\Projects\Tables\ProjectTable;
use Illuminate\Support\Collection;

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
}
