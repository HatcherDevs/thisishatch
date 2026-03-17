<?php

namespace SharjahStore\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProductInterface extends RepositoryInterface
{
    public function getPublished(int $limit = 20): Collection;
    
    public function getByCollection(int $collectionId, int $limit = 20): Collection;
}
