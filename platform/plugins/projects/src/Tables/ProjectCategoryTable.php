<?php

namespace Botble\Projects\Tables;

use Botble\Projects\Models\ProjectCategory;
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

class ProjectCategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(ProjectCategory::class)
            ->addHeaderActions([
                CreateHeaderAction::make()->route('projects.categories.create')->permission('projects.categories.create'),
            ])
            ->addActions([
                EditAction::make()->route('projects.categories.edit')->permission('projects.categories.edit'),
                DeleteAction::make()->route('projects.categories.destroy')->permission('projects.categories.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('projects.categories.destroy'))
            ->addBulkChanges([
                NameBulkChange::make()->validate('required|max:255'),
                CreatedAtBulkChange::make(),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('projects.categories.edit')->permission('projects.categories.edit'),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(fn (Builder $query) => $query->select([
                'id',
                'name',
                'created_at',
            ]));
    }
}
