<?php

return [
    [
        'name' => 'Projects',
        'flag' => 'projects.index',
        'parent_flag' => 'core.cms',
    ],
    [
        'name' => 'Create',
        'flag' => 'projects.create',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'projects.edit',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'projects.destroy',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Project Categories',
        'flag' => 'projects.categories.index',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Project Category Create',
        'flag' => 'projects.categories.create',
        'parent_flag' => 'projects.categories.index',
    ],
    [
        'name' => 'Project Category Edit',
        'flag' => 'projects.categories.edit',
        'parent_flag' => 'projects.categories.index',
    ],
    [
        'name' => 'Project Category Delete',
        'flag' => 'projects.categories.destroy',
        'parent_flag' => 'projects.categories.index',
    ],
    [
        'name' => 'Project Tags',
        'flag' => 'projects.tags.index',
        'parent_flag' => 'projects.index',
    ],
    [
        'name' => 'Project Tag Create',
        'flag' => 'projects.tags.create',
        'parent_flag' => 'projects.tags.index',
    ],
    [
        'name' => 'Project Tag Edit',
        'flag' => 'projects.tags.edit',
        'parent_flag' => 'projects.tags.index',
    ],
    [
        'name' => 'Project Tag Delete',
        'flag' => 'projects.tags.destroy',
        'parent_flag' => 'projects.tags.index',
    ],
];
