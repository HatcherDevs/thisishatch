<?php

namespace Botble\Page\Models;

use Botble\ACL\Models\User;
use Botble\Base\Casts\SafeContent;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;
use Botble\Revision\RevisionableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends BaseModel
{
    use RevisionableTrait;

    protected $table = 'pages';

    protected bool $revisionEnabled = true;

    protected bool $revisionCleanup = true;

    protected int $historyLimit = 20;

    protected array $dontKeepRevisionOf = ['content'];

    protected $fillable = [
        'name',
        'content',
        'down_row',
        'image',
        'template',
        'description',
        'status',
        'user_id',
        'parent_id',
        'order',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
        'name' => SafeContent::class,
        'description' => SafeContent::class,
        'template' => SafeContent::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id')->withDefault();
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('order');
    }

    protected static function booted(): void
    {
        static::creating(function (self $page): void {
            $page->user_id = $page->user_id ?: auth()->id() ?? null;
        });

        static::deleted(function (Page $page): void {
            // Reset parent_id for child pages to 0 when parent is deleted
            $page->children()->update(['parent_id' => 0]);
        });
    }
}
