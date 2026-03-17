<?php

return [
    [
        'name' => 'Research',
        'flag' => 'research.index',
        'is_feature' => true,
    ],
    [
        'name' => 'Timelines',
        'flag' => 'research.timelines.index',
        'parent_flag' => 'research.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'research.timelines.create',
        'parent_flag' => 'research.timelines.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'research.timelines.edit',
        'parent_flag' => 'research.timelines.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'research.timelines.destroy',
        'parent_flag' => 'research.timelines.index',
    ],
    [
        'name' => 'Locations',
        'flag' => 'research.locations.index',
        'parent_flag' => 'research.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'research.locations.create',
        'parent_flag' => 'research.locations.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'research.locations.edit',
        'parent_flag' => 'research.locations.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'research.locations.destroy',
        'parent_flag' => 'research.locations.index',
    ],
];
