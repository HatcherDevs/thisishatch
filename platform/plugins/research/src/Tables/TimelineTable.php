<?php

namespace Botble\Research\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Research\Models\Timeline;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;

class TimelineTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Timeline::class)
            ->addActions([
                EditAction::make()->route('research.timelines.edit'),
                DeleteAction::make()->route('research.timelines.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('research.timelines.edit'),
            Column::make('subtitle')
                ->title(trans('plugins/research::timelines.subtitle')),
            Column::make('order')
                ->title(trans('core/base::forms.order'))
                ->alignCenter(),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('research.timelines.create'), 'research.timelines.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('research.timelines.destroy'),
        ];
    }

    public function getFilters(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
        ];
    }
}
