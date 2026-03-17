<?php

return [
    [
        'name' => 'Repository Categories',
        'flag' => 'repository-categories.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'repository-categories.create',
        'parent_flag' => 'repository-categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'repository-categories.edit',
        'parent_flag' => 'repository-categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'repository-categories.destroy',
        'parent_flag' => 'repository-categories.index',
    ],
    [
        'name' => 'Repositories',
        'flag' => 'repository-items.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'repository-items.create',
        'parent_flag' => 'repository-items.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'repository-items.edit',
        'parent_flag' => 'repository-items.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'repository-items.destroy',
        'parent_flag' => 'repository-items.index',
    ],
];
