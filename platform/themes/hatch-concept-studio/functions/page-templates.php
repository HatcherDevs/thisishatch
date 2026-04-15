<?php

app()->booted(function (): void {
    register_page_template([
        'home' => __('Home'),
    ]);
});
