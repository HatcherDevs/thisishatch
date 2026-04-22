<?php

namespace Botble\Projects\Tables;

use Botble\Base\Facades\Assets;
use Botble\Projects\Models\Project;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\CreatedAtBulkChange;
use Botble\Table\BulkChanges\NumberBulkChange;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Botble\Table\HeaderActions\CreateHeaderAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProjectTable extends TableAbstract
{
    protected int $pageLength = -1;

    public function setup(): void
    {
        Assets::addScripts(['sortable']);

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
                NumberBulkChange::make()
                    ->name('order')
                    ->title(trans('core/base::tables.order'))
                    ->validate(['required', 'integer', 'min:0', 'max:999999']),
                CreatedAtBulkChange::make(),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make('title')
                    ->title(trans('plugins/projects::projects.form.title'))
                    ->route('projects.edit')
                    ->permission('projects.edit'),
                FormattedColumn::make('highlight')
                    ->title(trans('plugins/projects::projects.form.highlight'))
                    ->searchable(false)
                    ->orderable(false)
                    ->getValueUsing(function (FormattedColumn $column): string {
                        $project = $column->getItem();
                        $isChecked = (bool) ($project->highlight ?? false);

                        $checkedAttribute = $isChecked ? ' checked' : '';

                        return sprintf(
                            '<input type="checkbox" class="form-check-input project-highlight-toggle" data-url="%s"%s>',
                            route('projects.toggle-highlight', $project->id),
                            $checkedAttribute
                        );
                    }),
                Column::make('order')->title(trans('core/base::tables.order')),
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
                        'projects.highlight',
                        'projects.order',
                        'projects.year',
                        'projects.status',
                        'projects.created_at',
                        DB::raw('categories.name as category_name'),
                    ])
                    ->orderBy('projects.order')
                    ->orderByDesc('projects.id');
            });
    }

    public function htmlDrawCallbackFunction(): ?string
    {
        $reorderUrl = route('projects.reorder');

        $dragDropScript = str_replace('__REORDER_URL__', $reorderUrl, <<<'JS'
            (function (dtContext) {
                var tableNode = dtContext.api().table().node();

                if (! tableNode || typeof Sortable === 'undefined') {
                    return;
                }

                var tableBody = tableNode.querySelector('tbody');

                if (! tableBody) {
                    return;
                }

                if (tableBody._projectSortableInstance) {
                    tableBody._projectSortableInstance.destroy();
                    tableBody._projectSortableInstance = null;
                }

                tableBody.querySelectorAll('tr').forEach(function (row) {
                    row.style.cursor = 'move';
                });

                tableBody._projectSortableInstance = Sortable.create(tableBody, {
                    animation: 150,
                    draggable: 'tr',
                    filter: 'a,button,input,textarea,select,label,.btn,.dropdown,.dropdown-toggle,.dropdown-menu',
                    onEnd: function () {
                        var ids = [];

                        tableBody.querySelectorAll('tr').forEach(function (row) {
                            var checkbox = row.querySelector('input.checkboxes');

                            if (! checkbox) {
                                return;
                            }

                            var id = Number.parseInt(checkbox.value, 10);

                            if (! Number.isNaN(id) && id > 0) {
                                ids.push(id);
                            }
                        });

                        if (! ids.length) {
                            return;
                        }

                        $httpClient
                            .make()
                            .post('__REORDER_URL__', {
                                ids: ids,
                            })
                            .then(function (response) {
                                Botble.showSuccess(response.data.message);

                                if (window.LaravelDataTables && window.LaravelDataTables[tableNode.id]) {
                                    window.LaravelDataTables[tableNode.id].draw(false);
                                }
                            });
                    },
                });

                tableBody.querySelectorAll('.project-highlight-toggle').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        $httpClient
                            .make()
                            .post(checkbox.dataset.url, {
                                highlight: checkbox.checked ? 1 : 0,
                            })
                            .then(function (response) {
                                Botble.showSuccess(response.data.message);
                            })
                            .catch(function () {
                                checkbox.checked = ! checkbox.checked;
                            });
                    });
                });
            })(this);
        JS);

        return parent::htmlDrawCallbackFunction().$dragDropScript;
    }
}
