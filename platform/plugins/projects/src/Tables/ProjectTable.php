<?php

namespace Botble\Projects\Tables;

use Botble\Projects\Models\Project;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProjectTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Project::class)
            ->addHeaderActions([
                CreateHeaderAction::make()->route('projects.create')->permission('projects.create'),
            ])
            ->addActions([
                EditAction::make()->route('projects.edit')->permission('projects.edit'),
                DeleteAction::make()->route('projects.destroy')->permission('projects.destroy'),
            ])
            ->addBulkAction(DeleteBulkAction::make()->permission('projects.destroy'))
            ->addBulkChanges([
                CreatedAtBulkChange::make(),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('title')
                    ->title(trans('plugins/projects::projects.form.title'))
                    ->route('projects.edit')
                    ->permission('projects.edit'),
                Column::make('year')->title(trans('plugins/projects::projects.form.year')),
                Column::make('category_name')->title(trans('plugins/projects::projects.form.category')),
                StatusColumn::make(),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function (Builder $query): Builder {
                return $query
                    ->leftJoin('project_categories as categories', 'categories.id', '=', 'projects.category_id')
                    ->select([
                        'projects.id',
                        'projects.title',
                        'projects.year',
                        'projects.status',
                        'projects.created_at',
                        DB::raw('categories.name as category_name'),
                    ]);
            });
    }
}
