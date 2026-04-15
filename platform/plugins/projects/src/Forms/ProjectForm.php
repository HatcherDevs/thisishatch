<?php

namespace Botble\Projects\Forms;

use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImagesFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\FieldOptions\TagFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\MediaImagesField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TagField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Projects\Http\Requests\ProjectRequest;
use Botble\Projects\Models\Project;
use Botble\Projects\Models\ProjectCategory;

class ProjectForm extends FormAbstract
{
    public function setup(): void
    {
        $categoryChoices = ProjectCategory::query()->pluck('name', 'id')->all();

        $tagValue = null;
        $model = $this->getModel();

        if ($model && $model->exists) {
            $tagValue = $model->tags()->pluck('name')->implode(',');
        }

        $this
            ->model(Project::class)
            ->setValidatorClass(ProjectRequest::class)
            ->add(
                'title',
                TextField::class,
                NameFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.title'))
                    ->required()
            )
            ->add(
                'year',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.year'))
                    ->maxLength(10)
            )
            ->add(
                'tagline',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.tagline'))
                    ->rows(4)
            )
            ->add(
                'content',
                EditorField::class,
                ContentFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.content'))
                    ->allowedShortcodes()
            )
            ->add(
                'videos_ui',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->view('plugins/projects::forms.videos-field', [
                        'videos' => $model?->videos ?? [],
                    ])
            )
            ->add(
                'status',
                SelectField::class,
                StatusFieldOption::make()
            )
            ->add(
                'category_id',
                SelectField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.category'))
                    ->choices($categoryChoices)
                    ->emptyValue(trans('core/base::forms.select_placeholder'))
            )
            ->add(
                'tag_names',
                TagField::class,
                TagFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.tags'))
                    ->placeholder(trans('plugins/projects::projects.form.tags'))
                    ->value($tagValue)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()->label(trans('plugins/projects::projects.form.image'))
            )
            ->add(
                'cover',
                MediaImageField::class,
                MediaImageFieldOption::make()->label(trans('plugins/projects::projects.form.cover'))
            )
            ->add(
                'gallery_images[]',
                MediaImagesField::class,
                MediaImagesFieldOption::make()
                    ->label(trans('plugins/projects::projects.form.gallery_images'))
                    ->values(array_filter($model?->gallery_images ?? []))
            )
            ->setBreakFieldPoint('status');
    }
}
