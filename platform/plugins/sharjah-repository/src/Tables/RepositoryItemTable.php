<?php

namespace ArchiElite\SharjahRepository\Tables;

use ArchiElite\SharjahRepository\Models\RepositoryItem;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\BulkChanges\StatusBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;

class RepositoryItemTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(RepositoryItem::class)
            ->addActions([
                EditAction::make()->route('repository-items.edit'),
                DeleteAction::make()->route('repository-items.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('title')->route('repository-items.edit')->alignLeft()->title(trans('plugins/sharjah-repository::repository.title')),
                Column::make('category_id')
                    ->title(trans('plugins/sharjah-repository::repository.category'))
                    ->alignLeft(),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addHeaderAction(CreateHeaderAction::make()->route('repository-items.create'))
            ->addBulkActions([
                DeleteBulkAction::make()->permission('repository-items.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
                StatusBulkChange::make(),
                CreatedAtBulkChange::make(),
            ]);
    }
}
