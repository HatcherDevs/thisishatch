<?php

use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Shortcode\Compilers\Shortcode as ShortcodeCompiler;
use Botble\Shortcode\Facades\Shortcode;
use Botble\Shortcode\Forms\FieldOptions\ShortcodeTabsFieldOption;
use Botble\Shortcode\Forms\Fields\ShortcodeTabsField;
use Botble\Shortcode\Forms\ShortcodeForm;
use Botble\Theme\Facades\Theme;
use Botble\Theme\Supports\ThemeSupport;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Event;

Event::listen(RouteMatched::class, function (): void {
    ThemeSupport::registerGoogleMapsShortcode();
    ThemeSupport::registerYoutubeShortcode();

    // Video Block
    Shortcode::register(
        'video-block',
        __('Video Block'),
        __('Display a video with title and description'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.video-block', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('video-block', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'video_url',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Video URL'))
                    ->placeholder('https://www.youtube.com/watch?v=xxxxx or https://vimeo.com/xxxxx')
                    ->helperText(__('Enter YouTube or Vimeo video URL'))
                    ->required()
            )
            ->add(
                'preview_image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Preview Image'))
                    ->helperText(__('Upload a preview image for the video (optional, will use default thumbnail if empty)'))
            )
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->placeholder(__('Enter video title'))
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
                    ->placeholder(__('Enter video description'))
                    ->rows(4)
            );
    });

    // Image Gallery Block
    Shortcode::register(
        'image-gallery',
        __('Image Gallery'),
        __('Display multiple images with captions'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.image-gallery', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('image-gallery', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Gallery Title'))
                    ->placeholder(__('Enter gallery title (optional)'))
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Gallery Description'))
                    ->placeholder(__('Enter gallery description (optional)'))
                    ->rows(3)
            )
            ->add(
                'images',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->min(1)
                    ->max(20)
                    ->fields([
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                        'caption' => [
                            'type' => 'text',
                            'title' => __('Caption'),
                        ],
                    ])
                    ->attrs($attributes)
            )
            // Make tabs sortable in admin using client-side JS fallback (no PHP API required)
            ->addAfter(
                'images',
                'make_tabs_sortable',
                'html',
                [
                    'html' => '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                try {
                                    // The tabs container in Botble shortcode field typically uses .shortcode-tabs-list or similar selectors.
                                    // We will try multiple selectors for compatibility.
                                    var selectors = [
                                        ".shortcode-tabs-list",
                                        ".shortcode-tabs .nav, .shortcode-tabs-list",
                                        ".shortcode-form-group .nav-tabs",
                                        ".repeater-items, .shortcode-tabs-list"
                                    ];
                                    var list = null;
                                    for (var i = 0; i < selectors.length; i++) {
                                        var el = document.querySelector(selectors[i]);
                                        if (el) { list = el; break; }
                                    }
                                    if (!list) return;

                                    // If Sortable (from SortableJS) is available, use it.
                                    if (window.Sortable) {
                                        new Sortable(list, { animation: 150, handle: ".nav-link, .tab-handle, .draggable-handle" });
                                    } else if (window.jQuery && jQuery.fn && jQuery.fn.sortable) {
                                        jQuery(list).sortable({ handle: ".nav-link, .tab-handle, .draggable-handle" });
                                    } else {
                                        // As a last resort, add small drag handle UI and listen for mouse events to reorder simple list items.
                                        var items = list.children;
                                        for (var j = 0; j < items.length; j++) {
                                            var it = items[j];
                                            if (!it.querySelector(".draggable-handle")) {
                                                var handle = document.createElement("span");
                                                handle.className = "draggable-handle";
                                                handle.style.cssText = "cursor:move;display:inline-block;margin-left:8px;opacity:0.6";
                                                handle.innerHTML = "☰";
                                                it.appendChild(handle);
                                            }
                                        }
                                        // No full reordering implementation here to avoid complexity; primary goal is to enable Sortable if available.
                                    } catch (e) {
                                    // fail silently
                                    console && console.log && console.log("make_tabs_sortable error", e);
                                }
                            }, 200);
                        });
                    </script>'
                ]
            )
            ->addAfter(
                'images',
                'hide_quantity_script',
                'html',
                [
                    'html' => '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            setTimeout(function() {
                                // Hide the Quantity dropdown
                                const quantityWrapper = document.querySelector(".shortcode-form-group.quantity-wrapper");
                                if (quantityWrapper) {
                                    quantityWrapper.style.display = "none";
                                }
                            }, 100);
                        });
                    </script>'
                ]
            );
    });

    // Title & Description Block
    Shortcode::register(
        'title-description',
        __('Title & Description'),
        __('Display a title with description'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.title-description', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('title-description', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Title'))
                    ->placeholder(__('Enter title'))
                    ->required()
            )
            ->add(
                'description',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Description'))
                    ->placeholder(__('Enter description'))
                    ->rows(6)
            );
    });

    // Section Model Block
    Shortcode::register(
        'section-model',
        __('Section Model'),
        __('Display a custom section with title, content and image'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.section-model', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('section-model', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
            ->add(
                'title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Section Title'))
                    ->placeholder(__('Enter section title'))
                    ->required()
            )
            ->add(
                'content',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(__('Content'))
                    ->placeholder(__('Enter section content'))
                    ->rows(6)
            )
            ->add(
                'image',
                MediaImageField::class,
                MediaImageFieldOption::make()
                    ->label(__('Image'))
                    ->helperText(__('Upload an image for this section'))
            );
    });

    // Home Model Block - Multiple Items with Rich Content
    Shortcode::register(
        'home-model',
        __('Home Model'),
        __('Display multiple items with images/videos, category, date, time, title, description, and CTA'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.home-model', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('home-model', function (array $attributes) {
        $form = ShortcodeForm::createFromArray($attributes)
            ->add(
                'items',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->min(1)
                    ->max(50)
                    ->fields([
                        'media_image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                        'category' => [
                            'type' => 'text',
                            'title' => __('Category'),
                            'placeholder' => __('e.g., Architecture, Design, Event'),
                        ],
                        'date' => [
                            'type' => 'text',
                            'title' => __('Date'),
                            'placeholder' => 'YYYY-MM-DD or custom format',
                        ],
                        'time' => [
                            'type' => 'text',
                            'title' => __('Time'),
                            'placeholder' => 'HH:MM',
                        ],
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'rows' => 4,
                        ],
                        'button_text' => [
                            'type' => 'text',
                            'title' => __('Button Text'),
                            'placeholder' => __('Read More, Learn More, etc.'),
                        ],
                        'button_link' => [
                            'type' => 'text',
                            'title' => __('Button Link/File'),
                            'placeholder' => 'https://example.com or /path/to/file',
                        ],
                    ])
                    ->attrs($attributes)
            );

        return $form;
    });

    // Cusmize Row Block
    Shortcode::register(
        'cusmize-row',
        __('Cusmize Row'),
        __('Display multiple items as rows with image, title, category, description, and link'),
        function (ShortcodeCompiler $shortcode) {
            return Theme::partial('shortcodes.cusmize-row', compact('shortcode'));
        }
    );

    Shortcode::setAdminConfig('cusmize-row', function (array $attributes) {
        return ShortcodeForm::createFromArray($attributes)
 
            ->add(
                'main_title',
                TextField::class,
                TextFieldOption::make()
                    ->label(__('Main Title'))
                    ->placeholder(__('Enter main title'))
            )
              ->add(
                'show_section',
                'select',
                [
                    'label' => __('Show section'),
                    'options' => [
                        '1' => __('Show'),
                        '0' => __('Hide'),
                    ],
                    'default' => '1',
                ]
            )
            ->add(
                'items',
                ShortcodeTabsField::class,
                ShortcodeTabsFieldOption::make()
                    ->min(1)
                    ->max(50)
                    ->fields([
                        'image' => [
                            'type' => 'image',
                            'title' => __('Image'),
                            'required' => true,
                        ],
                        'title' => [
                            'type' => 'text',
                            'title' => __('Title'),
                            'required' => true,
                        ],
                        'category' => [
                            'type' => 'text',
                            'title' => __('Category'),
                        ],
                        'description' => [
                            'type' => 'textarea',
                            'title' => __('Description'),
                            'rows' => 3,
                        ],
                        'link' => [
                            'type' => 'text',
                            'title' => __('Link'),
                            'placeholder' => 'https://example.com or /path',
                        ],
                        'show_item' => [
                            'type' => 'select',
                            'title' => __('Show Item'),
                            'options' => [
                                '1' => __('Show'),
                                '0' => __('Hide'),
                            ],
                            'default' => '1',
                        ],
                    ])
                    ->attrs($attributes)
            );
    });
});
