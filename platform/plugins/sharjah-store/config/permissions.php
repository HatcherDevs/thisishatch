<?php

return [
    [
        'name' => 'Store Collections',
        'flag' => 'store.collections.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'store.collections.create',
        'parent_flag' => 'store.collections.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'store.collections.edit',
        'parent_flag' => 'store.collections.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'store.collections.destroy',
        'parent_flag' => 'store.collections.index',
    ],

    [
        'name' => 'Store Products',
        'flag' => 'store.products.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'store.products.create',
        'parent_flag' => 'store.products.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'store.products.edit',
        'parent_flag' => 'store.products.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'store.products.destroy',
        'parent_flag' => 'store.products.index',
    ],
];
