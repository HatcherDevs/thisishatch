<?php

namespace Botble\SharjahEventCalendar\Tables;

use Botble\SharjahEventCalendar\Models\EventLocation;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;

class EventLocationTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(EventLocation::class)
            ->addActions([
                EditAction::make()->route('events.locations.edit'),
                DeleteAction::make()->route('events.locations.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('events.locations.edit'),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('events.locations.create'), 'events.locations.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('events.locations.destroy'),
        ];
    }
}
