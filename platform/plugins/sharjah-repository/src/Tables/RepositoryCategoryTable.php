<?php

namespace ArchiElite\SharjahRepository\Tables;

use ArchiElite\SharjahRepository\Models\RepositoryCategory;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;

class RepositoryCategoryTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(RepositoryCategory::class)
            ->addActions([
                EditAction::make()->route('repository-categories.edit'),
                DeleteAction::make()->route('repository-categories.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('repository-categories.edit')->alignLeft(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('repository-categories.create'))
            ->addBulkActions([
                DeleteBulkAction::make()->permission('repository-categories.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ]);
    }
}
