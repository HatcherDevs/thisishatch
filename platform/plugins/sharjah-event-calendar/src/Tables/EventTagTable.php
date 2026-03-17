<?php

namespace Botble\SharjahEventCalendar\Tables;

use Botble\SharjahEventCalendar\Models\EventTag;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;

class EventTagTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(EventTag::class)
            ->addActions([
                EditAction::make()->route('events.tags.edit'),
                DeleteAction::make()->route('events.tags.destroy'),
            ]);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()->route('events.tags.edit'),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('events.tags.create'), 'events.tags.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('events.tags.destroy'),
        ];
    }
}
