<?php

return [
    [
        'name' => 'Opportunities',
        'flag' => 'opportunities.index',
        'parent_flag' => 'core.cms',
    ],
    [
        'name' => 'Create',
        'flag' => 'opportunities.create',
        'parent_flag' => 'opportunities.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'opportunities.edit',
        'parent_flag' => 'opportunities.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'opportunities.destroy',
        'parent_flag' => 'opportunities.index',
    ],
];
