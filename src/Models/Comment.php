<?php

namespace JobMetric\Comment\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed user_id
 * @property mixed parent_id
 * @property mixed commentable_id
 * @property mixed commentable_type
 * @property mixed text
 * @property mixed published_at
 * @property mixed published_by
 * @property mixed user
 * @property mixed commentable
 */
class Comment extends Pivot
{
    protected $fillable = [
        'user_id',
        'parent_id',
        'commentable_id',
        'commentable_type',
        'text',
        'published_at',
        'published_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
        'parent_id' => 'integer',
        'text' => 'string',
        'published_at' => 'datetime',
        'published_by' => 'integer',
    ];

    public function getTable()
    {
        return config('comment.tables.comment', parent::getTable());
    }

    /**
     * user relationship
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * commentable relationship
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * published relationship
     *
     * @return MorphTo
     */
    public function published(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }
}
