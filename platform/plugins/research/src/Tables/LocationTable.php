<?php

namespace Botble\Research\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Research\Models\Location;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;

class LocationTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Location::class)
            ->queryUsing(function ($query) {
                return $query->with('timeline');
            })
            ->addActions([
                EditAction::make()->route('research.locations.edit'),
                DeleteAction::make()->route('research.locations.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            Column::make('title')
                ->title(trans('plugins/research::locations.title'))
                ->route('research.locations.edit'),
            Column::make('subtitle')
                ->title(trans('plugins/research::locations.subtitle')),
            Column::make('timeline.name')
                ->title(trans('plugins/research::locations.timeline'))
                ->orderable(false)
                ->searchable(false),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('research.locations.create'), 'research.locations.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('research.locations.destroy'),
        ];
    }

    public function getFilters(): array
    {
        return [
            'title' => [
                'title' => trans('plugins/research::locations.title'),
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
