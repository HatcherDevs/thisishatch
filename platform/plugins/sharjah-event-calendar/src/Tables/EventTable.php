<?php

namespace Botble\SharjahEventCalendar\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\SharjahEventCalendar\Models\Event;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\Actions\Action;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class EventTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Event::class)
            ->addActions([
                EditAction::make()->route('events.edit'),
                Action::make('registrations')
                    ->route('events.registrations.index')
                    ->label('View Registrations')
                    ->color('info')
                    ->icon('fas fa-users'),
                DeleteAction::make()->route('events.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('events.edit'),
            CreatedAtColumn::make()
                ->title(trans('core/base::tables.created_at')),
            StatusColumn::make()
                ->title(trans('core/base::tables.status')),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('events.create'), 'events.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('events.destroy'),
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
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'date',
            ],
        ];
    }

    public function query(): Relation|Builder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                // 'start_date',
                // 'event_category_id',
                // 'event_location_id',
                'status',
                'created_at',
            ])
            ->with(['category', 'location', 'registrations']);

        return $this->applyScopes($query);
    }
}
