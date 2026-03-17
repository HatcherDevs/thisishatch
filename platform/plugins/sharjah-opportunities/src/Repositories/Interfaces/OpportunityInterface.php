<?php

namespace SharjahOpportunities\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;

interface OpportunityInterface extends RepositoryInterface
{
    public function getPublished(int $limit = 10, array $with = []);
    
    public function getBySlug(string $slug, array $with = []);
    
    public function getByPermalink(string $permalink, array $with = []);
    
    public function getFeatured(int $limit = 5, array $with = []);
}
