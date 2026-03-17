<?php

namespace SharjahOpportunities\Tables;

use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use SharjahOpportunities\Models\Opportunity;

class OpportunityTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Opportunity::class)
            ->addActions([
                EditAction::make()->route('opportunities.edit'),
                DeleteAction::make()->route('opportunities.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('opportunities.edit'),
                CreatedAtColumn::make(),
                StatusColumn::make(),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('opportunities.destroy'),
            ])
            ->queryUsing(function (Builder $query) {
                return $query->select([
                    'id',
                    'name',
                    'created_at',
                    'status',
                ]);
            });
    }
}
