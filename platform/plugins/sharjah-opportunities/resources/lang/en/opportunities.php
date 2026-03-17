<?php

return [
    'name' => 'Opportunities',
    'create' => 'New opportunity',
    'edit' => 'Edit opportunity',
    'form' => [
        'name' => 'Name',
        'name_placeholder' => 'Opportunity name (Maximum 255 characters)',
        'permalink' => 'Permalink',
        'permalink_placeholder' => 'Permalink (auto-generated from name if empty)',
        'description' => 'Description',
        'description_placeholder' => 'Short description (Maximum 400 characters)',
        'content' => 'Content',
        'image' => 'Featured image',
        'note' => 'Note content',
        'format_type' => 'Format type',
    ],
    'statuses' => [
        'draft' => 'Draft',
        'pending' => 'Pending',
        'published' => 'Published',
    ],
    'notices' => [
        'no_select' => 'Please select at least one opportunity to take this action!',
        'update_success_message' => 'Updated successfully',
    ],
    'cannot_delete' => 'Opportunity could not be deleted',
    'deleted' => 'Opportunity deleted',
    'menu' => 'Opportunities',
    'shortcode_name' => 'Opportunities',
    'shortcode_description' => 'Display a list of opportunities (UI block).',
];
