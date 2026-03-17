<?php

namespace Botble\SharjahEventCalendar\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FieldOptions\ContentFieldOption;
use Botble\Base\Forms\FieldOptions\DatePickerFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\DatePickerField;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\SharjahEventCalendar\Http\Requests\EventRequest;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\SharjahEventCalendar\Models\EventCategory;
use Botble\SharjahEventCalendar\Models\EventLocation;
use Botble\SharjahEventCalendar\Models\EventTag;

class EventForm extends FormAbstract
{
    public function buildForm(): void
    {
        $categories = EventCategory::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->pluck('name', 'id')
            ->all();

        $locations = EventLocation::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->pluck('name', 'id')
            ->all();

        $tags = EventTag::query()
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->pluck('name', 'id')
            ->all();

        $selectedTags = [];
        if ($this->getModel()) {
            $selectedTags = $this->getModel()->tags()->pluck('event_tags.id')->all();
        }

        $this
            ->setupModel(new Event)
            ->setValidatorClass(EventRequest::class)
            ->withCustomFields()
            // Main content fields (Left side)
            ->add('name', TextField::class, TextFieldOption::make()
                ->label(trans('core/base::forms.name'))
                ->placeholder(trans('core/base::forms.name_placeholder'))
                ->required()
                ->maxLength(255)
                ->toArray())
            ->add('description', TextareaField::class, TextareaFieldOption::make()
                ->label(trans('core/base::forms.description'))
                ->placeholder(trans('core/base::forms.description_placeholder'))
                ->rows(4)
                ->toArray())
            ->add('content', EditorField::class, ContentFieldOption::make()
                ->label(trans('core/base::forms.content'))
                ->placeholder(trans('core/base::forms.content_placeholder'))
                ->allowedShortcodes()
                ->toArray())

            // Sidebar fields (Right side) - all fields after this break point
            ->add('status', SelectField::class, SelectFieldOption::make()
                ->label(trans('core/base::tables.status'))
                ->choices(BaseStatusEnum::labels())
                ->toArray())
            ->add('image', MediaImageField::class, MediaImageFieldOption::make()
                ->label(trans('core/base::forms.image'))
                ->toArray())
            ->add('event_category_id', SelectField::class, SelectFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.category'))
                ->choices(['' => trans('plugins/sharjah-event-calendar::events.form.select_category')] + $categories)
                ->toArray())
            ->add('event_location_id', SelectField::class, SelectFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.location'))
                ->choices(['' => trans('plugins/sharjah-event-calendar::events.form.select_location')] + $locations)
                ->toArray())
            ->add('start_date', DatePickerField::class, DatePickerFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.start_date'))
                ->defaultValue(null)
                ->toArray())
            ->add('end_date', DatePickerField::class, DatePickerFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.end_date'))
                ->defaultValue(null)
                ->toArray())
            ->add('start_time', TextField::class, TextFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.start_time'))
                ->addAttribute('type', 'time')
                ->helperText('Optional: Select event start time (e.g., 14:00)')
                ->toArray())
            ->add('end_time', TextField::class, TextFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.end_time'))
                ->addAttribute('type', 'time')
                ->helperText('Optional: Select event end time (e.g., 18:00)')
                ->toArray())
            ->add('has_registration', OnOffField::class, OnOffFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.enable_registration'))
                ->defaultValue(false)
                ->toArray())
            ->add('registration_deadline', DatePickerField::class, DatePickerFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.registration_deadline'))
                ->defaultValue(null)
                ->toArray())
            ->add('max_attendees', NumberField::class, NumberFieldOption::make()
                ->label(trans('plugins/sharjah-event-calendar::events.form.max_attendees'))
                ->toArray())
            ->setBreakFieldPoint('status');
    }
}
