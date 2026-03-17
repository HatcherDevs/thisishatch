<?php

return [
    // Events
    [
        'name' => 'Events',
        'flag' => 'events.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'events.create',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'events.edit',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'events.destroy',
        'parent_flag' => 'events.index',
    ],

    // Event Categories
    [
        'name' => 'Event Categories',
        'flag' => 'events.categories.index',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'events.categories.create',
        'parent_flag' => 'events.categories.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'events.categories.edit',
        'parent_flag' => 'events.categories.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'events.categories.destroy',
        'parent_flag' => 'events.categories.index',
    ],

    // Event Tags
    [
        'name' => 'Event Tags',
        'flag' => 'events.tags.index',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'events.tags.create',
        'parent_flag' => 'events.tags.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'events.tags.edit',
        'parent_flag' => 'events.tags.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'events.tags.destroy',
        'parent_flag' => 'events.tags.index',
    ],

    // Event Locations
    [
        'name' => 'Event Locations',
        'flag' => 'events.locations.index',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'events.locations.create',
        'parent_flag' => 'events.locations.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'events.locations.edit',
        'parent_flag' => 'events.locations.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'events.locations.destroy',
        'parent_flag' => 'events.locations.index',
    ],

    // Event Registrations
    [
        'name' => 'Event Registrations',
        'flag' => 'events.registrations.index',
        'parent_flag' => 'events.index',
    ],
    [
        'name' => 'View',
        'flag' => 'events.registrations.show',
        'parent_flag' => 'events.registrations.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'events.registrations.edit',
        'parent_flag' => 'events.registrations.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'events.registrations.destroy',
        'parent_flag' => 'events.registrations.index',
    ],
    [
        'name' => 'Export',
        'flag' => 'events.registrations.export',
        'parent_flag' => 'events.registrations.index',
    ],
];
