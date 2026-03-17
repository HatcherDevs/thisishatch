<?php

namespace SharjahStore\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Collection;
use SharjahStore\Repositories\Interfaces\ProductInterface;

class ProductRepository extends RepositoriesAbstract implements ProductInterface
{
    public function getPublished(int $limit = 20): Collection
    {
        return $this->model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->with('collection')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getByCollection(int $collectionId, int $limit = 20): Collection
    {
        return $this->model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('collection_id', $collectionId)
            ->with('collection')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
