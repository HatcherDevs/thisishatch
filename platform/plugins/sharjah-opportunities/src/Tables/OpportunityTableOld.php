<?php

namespace SharjahOpportunities\Tables;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\ImageColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\StatusColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use SharjahOpportunities\Models\Opportunity;

class OpportunityTable extends TableAbstract
{
    public function __construct()
    {
        parent::__construct();

        $this->setOption('id', 'plugins-opportunities-table');
        $this->setOption('class', 'table table-striped table-hover vertical-middle');
        $this->setOption('pageLength', 20);

        $this->hasActions = true;
        $this->hasFilter = true;
        $this->hasCheckbox = true;
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Opportunity $item) {
                if (! $this->hasPermission('opportunities.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('opportunities.edit', $item->getKey()), BaseHelper::clean($item->name));
            })
            ->editColumn('image', function (Opportunity $item) {
                return $this->displayThumbnail($item->image);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = Opportunity::query()->select([
            'id',
            'name',
            'image',
            'created_at',
            'status',
        ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            IdColumn::make(),
            ImageColumn::make(),
            NameColumn::make()->route('opportunities.edit'),
            CreatedAtColumn::make(),
            StatusColumn::make(),
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('opportunities.create'), 'opportunities.create');
    }

    public function bulkActions(): array
    {
        return [
            DeleteBulkAction::make()->permission('opportunities.destroy'),
        ];
    }

    public function getBulkChanges(): array
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
                'type' => 'datePicker',
            ],
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
                'choices' => [0 => trans('core/base::tables.deactivate'), 1 => trans('core/base::tables.activate')],
                'validate' => 'required|in:0,1',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }

    public function getDefaultButtons(): array
    {
        return [
            'edit' => EditAction::make()->route('opportunities.edit'),
            'delete' => DeleteAction::make()->route('opportunities.destroy'),
        ];
    }
}