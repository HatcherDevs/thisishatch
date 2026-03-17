<?php

namespace Botble\Research\Database\Seeders;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Research\Models\Timeline;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TimelineSeeder extends Seeder
{
    public function run(): void
    {
        $timelines = [
            [
                'name' => 'Pre-1960',
                'subtitle' => 'Early development phase',
                'order' => 1,
            ],
            [
                'name' => '1960-1980',
                'subtitle' => 'Foundation period',
                'order' => 2,
            ],
            [
                'name' => '1981-2000',
                'subtitle' => 'Expansion era',
                'order' => 3,
            ],
            [
                'name' => '2001-2020',
                'subtitle' => 'Modern development',
                'order' => 4,
            ],
            [
                'name' => '2020-present',
                'subtitle' => 'Current projects',
                'order' => 5,
            ],
        ];

        foreach ($timelines as $timeline) {
            Timeline::query()->create([
                'name' => $timeline['name'],
                'subtitle' => $timeline['subtitle'],
                'slug' => Str::slug($timeline['name']),
                'order' => $timeline['order'],
                'status' => BaseStatusEnum::PUBLISHED,
            ]);
        }
    }
}
