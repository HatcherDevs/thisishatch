<?php

namespace SharjahStore\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Illuminate\Database\Eloquent\Collection;
use SharjahStore\Repositories\Interfaces\CollectionInterface;

class CollectionRepository extends RepositoriesAbstract implements CollectionInterface
{
    public function getPublished(int $limit = 20): Collection
    {
        return $this->model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
