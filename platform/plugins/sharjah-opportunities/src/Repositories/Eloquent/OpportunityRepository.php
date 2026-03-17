<?php

namespace SharjahOpportunities\Repositories\Eloquent;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use SharjahOpportunities\Repositories\Interfaces\OpportunityInterface;

class OpportunityRepository extends RepositoriesAbstract implements OpportunityInterface
{
    public function getPublished(int $limit = 10, array $with = [])
    {
        $data = $this->model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderByDesc('created_at');

        if ($with) {
            $data = $data->with($with);
        }

        if ($limit > 0) {
            $data = $data->limit($limit);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    public function getBySlug(string $slug, array $with = [])
    {
        $data = $this->model
            ->where('slug', $slug)
            ->where('status', BaseStatusEnum::PUBLISHED);

        if ($with) {
            $data = $data->with($with);
        }

        return $this->applyBeforeExecuteQuery($data)->first();
    }

    public function getByPermalink(string $permalink, array $with = [])
    {
        return $this->getBySlug($permalink, $with);
    }

    public function getFeatured(int $limit = 5, array $with = [])
    {
        $data = $this->model
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->orderByDesc('created_at');

        if ($with) {
            $data = $data->with($with);
        }

        if ($limit > 0) {
            $data = $data->limit($limit);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
