<?php

namespace Botble\Projects\Tables;

use Botble\Projects\Models\ProjectTag;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;

class ProjectTagTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProjectTag::class)
            ->addHeaderActions([
                CreateHeaderAction::make()->route('projects.tags.create')->permission('projects.tags.create'),
            ])
            ->addActions([
                EditAction::make()->route('projects.tags.edit')->permission('projects.tags.edit'),
                DeleteAction::make()->route('projects.tags.destroy')->permission('projects.tags.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('projects.tags.destroy'))
            ->addBulkChanges([
                NameBulkChange::make()->validate('required|max:255'),
                CreatedAtBulkChange::make(),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('projects.tags.edit')->permission('projects.tags.edit'),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(fn (Builder $query) => $query->select([
                'id',
                'name',
                'created_at',
            ]));
    }
}
